<?php

namespace Core\Domain\Services\Transactions;

use Core\Domain\Contracts\IAuthorisationService;
use Core\Domain\Contracts\INotificationService;
use Core\Domain\Entities\Transaction\Contracts\ITransactionsEntity;
use Core\Domain\Entities\Transaction\TransactionsEntity;
use Core\Domain\Entities\Users\CommonUsersEntity;
use Core\Domain\Entities\Users\ShopkeepersUsersEntity;
use Core\Domain\Entities\Users\UsersEntity;
use Core\Domain\Repositories\ITransactionRepository;
use Core\Domain\Repositories\IUserRepository;
use Core\Domain\Services\Transactions\Contracts\ITransactionService;

class TransactionService implements ITransactionService
{
    public function __construct(
        private readonly ITransactionRepository $transactionRepository,
        private readonly IUserRepository        $userRepository,
        private readonly IAuthorisationService  $authorizerService,
        private readonly INotificationService   $notificationService,
    )
    {
    }

    public function makeTransactionUser(string $payer, string $payee, float $value): void
    {

        $findPayer = $this->userRepository->findById($payer);
        if(!$findPayer){
            throw new \Error('Payer not found.');
        }
        $payerUser = new CommonUsersEntity(
            $findPayer['fullname'],
            $findPayer['email'],
            $findPayer['password'],
            $findPayer['cpf_cnpj'],
            $findPayer['wallet'],
        );
        $findPayee = $this->userRepository->findById($payee);
        if(!$findPayee){
            throw new \Error('Payee user not found.');
        }
        $payeeUser = new UsersEntity();
        $payeeUser->setFullname($findPayee['fullname']);
        $payeeUser->setEmail($findPayee['email']);
        $payeeUser->setPassword($findPayee['password']);
        $payeeUser->setCpfCnpj($findPayee['cpf_cnpj']);
        $payeeUser->setWallet($findPayee['wallet']);

        $transaction = new TransactionsEntity($payerUser, $payeeUser, $value);
        $isSuccess = $transaction->makeTransaction();
        if (!$isSuccess) {
            throw new \Error('Your balance is insufficient');
        }
        $isApproved = $this->authorizerService->authorisation();
        $isNotification = $this->notificationService->sendNotification();

        if(!$isApproved || !$isNotification){
            $transaction->revertTransaction();
            throw new \Error('Unauthorised transaction');
        }
        $this->userRepository->updateWallet($payerUser->getCpfCnpj(), $payerUser->getWallet());
        $this->userRepository->updateWallet($payeeUser->getCpfCnpj(), $payeeUser->getWallet());

        $this->transactionRepository->save($transaction);

    }
}
