<?php

namespace Core\Domain\Services\Transactions\Contracts;

interface ITransactionService
{
    public function makeTransactionUser(string $payer, string $payee, float $value);
}
