<?php

namespace Tests\Services;

use Core\Domain\Contracts\IAuthorisationExternal;
use Core\Domain\Contracts\INotificationExternal;
use Core\Domain\Entities\Users\CommonUsersEntity;
use Core\Domain\Entities\Users\ShopkeepersUsersEntity;
use Core\Domain\Repositories\ITransactionRepository;
use Core\Domain\Repositories\IUserRepository;
use Core\Domain\Services\Transactions\Contracts\ITransactionService;
use Core\Domain\Services\Transactions\TransactionService;
use PHPUnit\Framework\TestCase;

class TransactionServiceTest extends TestCase
{

    private ITransactionService $transactionService;
    private ITransactionRepository $transactionRepositoryMock;
    private IUserRepository $userRepositoryMock;
    private IAuthorisationExternal $authorisationService;
    private INotificationExternal $notificationService;
    private array $payerUser;
    private array $payeeUser;

    protected function setUp(): void
    {
        $this->transactionRepositoryMock = $this->createMock(ITransactionRepository::class);
        $this->userRepositoryMock = $this->createMock(IUserRepository::class);
        $this->authorisationService = $this->createMock(IAuthorisationExternal::class);
        $this->notificationService = $this->createMock(INotificationExternal::class);

        $this->payerUser = [[
            'id' => 1,
            'fullname' => 'origin_user',
            'email' => 'email@gmail.com',
            'password' => '12343894',
            'cpf_cnpj' => '62810641005',
            'wallet' => 500.0,
        ]];
        $this->payeeUser = [[
            'id' => 2,
            'fullname' => 'target_user',
            'email' => 'email@gmail.com',
            'password' => '12343894',
            'cpf_cnpj' => '00196978000170',
            'wallet' => 0.0,
        ]];

        $this->transactionService = new TransactionService(
            $this->transactionRepositoryMock,
            $this->userRepositoryMock,
            $this->authorisationService,
            $this->notificationService
        );
    }

    public function testMakeTransactionSuccess()
    {
        $payer = 1;
        $payee = 2;
        $value = 200;

        $payerUser = $this->payerUser;
        $payeeUser = $this->payeeUser;

        $this->authorisationService
            ->expects($this->once())
            ->method('authorisation')
            ->willReturn(true);

        $this->notificationService
            ->expects($this->once())
            ->method('sendNotification')
            ->willReturn(true);

        $this->userRepositoryMock
            ->expects($this->exactly(2))
            ->method('findById')
            ->willReturnCallback(function ($id) use ($payerUser, $payeeUser) {
                return match ($id) {
                    1 => $payerUser,
                    2 => $payeeUser,
                    default => null
                };
            });

        $this->userRepositoryMock
            ->expects($this->exactly(2))
            ->method('updateWallet');
        $this->transactionRepositoryMock->expects($this->once())->method('save')->willReturn(true);
        $response = $this->transactionService->makeTransactionUser($payer, $payee, $value);
        $this->assertSame(true, $response);

    }

    public function testExceptionMakeTransactionPayerNotFound()
    {
        $payer = 1010; //ĩnvalid payer
        $payee = 2;
        $value = 200;

        $payerUser = $this->payerUser;
        $payeeUser = $this->payeeUser;

        $this->userRepositoryMock
            ->expects($this->exactly(1))
            ->method('findById')
            ->willReturnCallback(function ($id) use ($payerUser, $payeeUser) {
                return match ($id) {
                    1 => $payerUser,
                    2 => $payeeUser,
                    default => null
                };
            });

        $this->expectExceptionMessage("Payer not found.");

        $this->transactionService->makeTransactionUser($payer, $payee, $value);

    }

    public function testExceptionMakeTransactionPayeeNotFound()
    {
        $payer = 1;
        $payee = 2234; //invalid peyee
        $value = 200;

        $payerUser = $this->payerUser;
        $payeeUser = $this->payeeUser;

        $this->userRepositoryMock
            ->expects($this->exactly(2))
            ->method('findById')
            ->willReturnCallback(function ($id) use ($payerUser, $payeeUser) {
                return match ($id) {
                    1 => $payerUser,
                    2 => $payeeUser,
                    default => null
                };
            });

        $this->expectExceptionMessage("Payee user not found.");

        $this->transactionService->makeTransactionUser($payer, $payee, $value);

    }

    public function testExceptionMakeTransactionInsufficientBalance()
    {
        $payer = 1;
        $payee = 2;
        $value = 600;

        $payerUser = $this->payerUser;
        $payeeUser = $this->payeeUser;

        $this->userRepositoryMock
            ->expects($this->exactly(2))
            ->method('findById')
            ->willReturnCallback(function ($id) use ($payerUser, $payeeUser) {
                return match ($id) {
                    1 => $payerUser,
                    2 => $payeeUser,
                    default => null
                };
            });

        $this->expectExceptionMessage('Your balance is insufficient');
        $this->transactionService->makeTransactionUser($payer, $payee, $value);
    }

    public function testExceptionMakeTransactionValueInvalid()
    {
        $payer = 1;
        $payee = 2;
        $value = -600;

        $payerUser = $this->payerUser;
        $payeeUser = $this->payeeUser;

        $this->userRepositoryMock
            ->expects($this->exactly(2))
            ->method('findById')
            ->willReturnCallback(function ($id) use ($payerUser, $payeeUser) {
                return match ($id) {
                    1 => $payerUser,
                    2 => $payeeUser,
                    default => null
                };
            });

        $this->expectExceptionMessage('The past and invalid value.');
        $this->transactionService->makeTransactionUser($payer, $payee, $value);
    }

    public function testExceptionMakeTransactionUserToUser()
    {
        $payer = 1;
        $payee = 3;
        $value = 100;

        $payerUser = $this->payerUser;
        $this->payeeUser['cpf_cnpj'] = '92832244009';
        $payeeUser = $this->payeeUser;


        $this->authorisationService
            ->expects($this->once())
            ->method('authorisation')
            ->willReturn(true);

        $this->notificationService
            ->expects($this->once())
            ->method('sendNotification')
            ->willReturn(true);

        $this->userRepositoryMock
            ->expects($this->exactly(2))
            ->method('findById')
            ->willReturnCallback(function ($id) use ($payerUser, $payeeUser) {
                return match ($id) {
                    1 => $payerUser,
                    3 => $payeeUser,
                    default => null
                };
            });

        $this->transactionService->makeTransactionUser($payer, $payee, $value);
    }

    public function testExceptionMakeTransactionNoAuthorisation()
    {
        $payer = 1;
        $payee = 3;
        $value = 100;

        $payerUser = $this->payerUser;
        $this->payeeUser['cpf_cnpj'] = '92832244009';
        $payeeUser = $this->payeeUser;


        $this->authorisationService
            ->expects($this->once())
            ->method('authorisation')
            ->willReturn(false);

        $this->notificationService
            ->expects($this->once())
            ->method('sendNotification')
            ->willReturn(true);

        $this->userRepositoryMock
            ->expects($this->exactly(2))
            ->method('findById')
            ->willReturnCallback(function ($id) use ($payerUser, $payeeUser) {
                return match ($id) {
                    1 => $payerUser,
                    3 => $payeeUser,
                    default => null
                };
            });
        $this->expectExceptionMessage('Unauthorised transaction');
        $this->transactionService->makeTransactionUser($payer, $payee, $value);
    }

    public function testMakeExceptionTransactionNoNotification()
    {
        $payer = 1;
        $payee = 3;
        $value = 100;

        $payerUser = $this->payerUser;
        $this->payeeUser['cpf_cnpj'] = '92832244009';
        $payeeUser = $this->payeeUser;


        $this->authorisationService
            ->expects($this->once())
            ->method('authorisation')
            ->willReturn(true);

        $this->notificationService
            ->expects($this->once())
            ->method('sendNotification')
            ->willReturn(false);

        $this->userRepositoryMock
            ->expects($this->exactly(2))
            ->method('findById')
            ->willReturnCallback(function ($id) use ($payerUser, $payeeUser) {
                return match ($id) {
                    1 => $payerUser,
                    3 => $payeeUser,
                    default => null
                };
            });
        $this->expectExceptionMessage('Unauthorised transaction');
        $this->transactionService->makeTransactionUser($payer, $payee, $value);
    }

    public function testSuccessWhenShowingExtrato()
    {
        $mockResult = [
            [
                "id" => 1,
                "user_payer_id" => 1,
                "user_payee_id" => 2,
                "value" => "150.000",
                "status" => "approved",
            ]
        ];
        $this->transactionRepositoryMock
            ->expects($this->exactly(1))
            ->method('findTransactionExtract')
            ->willReturn($mockResult);

        $result = $this->transactionService->extract(1);
        $this->assertSame($mockResult[0]['id'],$result[0]['id']);
        $this->assertSame($mockResult[0]['status'],$result[0]['status']);
        $this->assertSame($mockResult[0]['user_payee_id'],$result[0]['user_payee_id']);
    }

    public function testReturnNullInExtract()
    {
        $mockResult = [
        ];
        $this->transactionRepositoryMock
            ->expects($this->exactly(1))
            ->method('findTransactionExtract')
            ->willReturn($mockResult);

        $result = $this->transactionService->extract(1);
        $this->assertSame(null,$result);
    }
}
