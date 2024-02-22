<?php

namespace Core\Domain\Repositories;

use Core\Domain\Entities\Transaction\Contracts\ITransactionsEntity;

interface ITransactionRepository
{
    public function save(ITransactionsEntity $transactions): bool;
    public function findTransactionExtract(int $payerId): ?array;
}
