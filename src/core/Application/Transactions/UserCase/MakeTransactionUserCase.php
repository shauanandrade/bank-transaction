<?php

namespace Core\Application\Transactions\UserCase;

use Core\Application\Transactions\UserCase\Contracts\IMakeTransactionUseCase;
use Core\Domain\Services\Transactions\Contracts\ITransactionService;

class MakeTransactionUserCase implements IMakeTransactionUseCase
{

    public function __construct(public readonly ITransactionService $transactionService)
    {

    }

    public function execute(string $payer, string $payee, float $value): void
    {
        $this->transactionService->makeTransactionUser($payer,$payee,$value);
    }
}
