<?php

namespace App\Infrastructure\Repositories;

use App\Models\Transactions;
use Core\Domain\Entities\Transaction\Contracts\ITransactionsEntity;
use Core\Domain\Repositories\ITransactionRepository;

class TransactionRepository implements ITransactionRepository
{

    public function save(ITransactionsEntity $transactions): bool
    {
            Transactions::create([
                'user_payer_id' => $transactions->getPayer()->getId(),
                'user_payee_id' => $transactions->getPayee()->getId(),
                'value' => $transactions->getValue(),
                'status' => $transactions->getStatus()
            ]);
            return true;
    }

    public function findTransactionExtract(int $payerId): ?array
    {
        return Transactions::where('user_payer_id', $payerId)->orWhere('user_payee_id', $payerId)->get()->toArray();
    }
}
