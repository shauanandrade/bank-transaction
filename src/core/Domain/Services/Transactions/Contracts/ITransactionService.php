<?php

namespace Core\Domain\Services\Transactions\Contracts;

interface ITransactionService
{
    public function makeTransactionUser(int $payer, int $payee, float $value):bool;
    public function extract(int $payer);

}
