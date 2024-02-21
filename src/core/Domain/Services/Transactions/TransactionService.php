<?php

namespace Core\Domain\Services\Transactions;

use Core\Domain\Contracts\IAuthorisationService;
use Core\Domain\Contracts\INotificationService;
use Core\Domain\Entities\Transaction\Contracts\ITransactionsEntity;
use Core\Domain\Entities\Transaction\TransactionsEntity;
use Core\Domain\Entities\Users\CommonUsersEntity;
use Core\Domain\Entities\Users\Contracts\ICommonUsersEntity;
use Core\Domain\Entities\Users\Contracts\IShopkeepersUsersEntity;
use Core\Domain\Entities\Users\Contracts\IUsersEntity;
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

    private function findPayer(string $payer): ICommonUsersEntity
    {
        $findPayer = $this->userRepository->findById($payer);
        if (!$findPayer) {
            throw new \Error('Payer not found.');
        }

        if(strlen($findPayer[0]['cpf_cnpj']) !== 11){
            throw new \Error('Payer is not a Common user.');
        }

        $payerUser = new CommonUsersEntity(
            $findPayer[0]['fullname'] ?? '',
            $findPayer[0]['email'] ?? '',
            $findPayer[0]['password'] ?? '',
            $findPayer[0]['cpf_cnpj'] ?? '',
            $findPayer[0]['wallet'] ?? '',
        );
        $payerUser->setId($findPayer[0]['id']);

        return $payerUser;
    }

    private function findPayee(string $payee): IUsersEntity
    {
        $findPayee = $this->userRepository->findById($payee);
        if (!$findPayee) {
            throw new \Error('Payee user not found.');
        }
        $payeeUser = new UsersEntity();
        $payeeUser->setId($findPayee[0]['id']);
        $payeeUser->setFullname($findPayee[0]['fullname']);
        $payeeUser->setEmail($findPayee[0]['email']);
        $payeeUser->setCpfCnpj($findPayee[0]['cpf_cnpj']);
        $payeeUser->setWallet($findPayee[0]['wallet']);

        return $payeeUser;
    }

    public function makeTransactionUser(int $payer, int $payee, float $value): bool
    {
        $payerUser = $this->findPayer($payer);

        $payeeUser = $this->findPayee($payee);

        $transaction = new TransactionsEntity($payerUser, $payeeUser, $value);

        $isSuccess = $transaction->makeTransaction();
        if (!$isSuccess) {
            throw new \Error('Your balance is insufficient');
        }

        $isApproved = $this->authorizerService->authorisation();
        $isNotification = $this->notificationService->sendNotification();
        if (!$isApproved || !$isNotification) {
            $transaction->revertTransaction();
            throw new \Error('Unauthorised transaction');
        }

        $this->userRepository->updateWallet($payerUser->getCpfCnpj(), $payerUser->getWallet());
        $this->userRepository->updateWallet($payeeUser->getCpfCnpj(), $payeeUser->getWallet());

        return $this->transactionRepository->save($transaction);
    }

    public function extract(int $payer): ?array
    {
        $extract = $this->transactionRepository->findTransactionExtract($payer);
        if (!(isset($extract[0]) && $extract[0]))
            return null;

        return $extract;
    }
}
