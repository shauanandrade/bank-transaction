<?php

namespace Core\Application\Transactions\UserCase;

use Core\Application\Transactions\UserCase\Contracts\IExtractPayerTransactionUserCase;
use Core\Domain\Services\Transactions\Contracts\ITransactionService;

class ExtractPayerTransactionUserCase implements IExtractPayerTransactionUserCase
{

    public function __construct(public readonly ITransactionService $transactionService)
    {

    }

    public function execute(int $payer): ?array
    {
       return  $this->transactionService->extract($payer);
    }
}
