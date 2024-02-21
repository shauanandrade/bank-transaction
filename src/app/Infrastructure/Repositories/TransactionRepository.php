<?php

namespace App\Infrastructure\Repositories;

use App\Models\Transactions;
use Core\Domain\Entities\Transaction\Contracts\ITransactionsEntity;
use Core\Domain\Repositories\ITransactionRepository;

class TransactionRepository implements ITransactionRepository
{

    public function save(ITransactionsEntity $transactions): void
    {
        Transactions::created([
            'origin' => $transactions->getPayer()->getCpfCnpj(),
            'target' => $transactions->getPayee()->getCpfCnpj(),
            'value' => $transactions->getValue(),
            'status' => $transactions->getStatus()
        ]);
    }
}
