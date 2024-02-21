<?php

namespace Core\Application\Transactions\UserCase\Contracts;


interface IExtractPayerTransactionUserCase
{
    public function execute(int $payer):?array;
}
