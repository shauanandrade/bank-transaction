<?php

namespace Core\Application\Transactions\UserCase\Contracts;


interface IMakeTransactionUseCase
{
    public function execute(string $payer, string $payee, float $value):bool;
}
