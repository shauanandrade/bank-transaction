<?php

namespace Core\Domain\Contracts;

use Core\Domain\Entities\Transaction\Contracts\ITransactionsEntity;

interface INotificationExternal
{
    public function sendNotification(ITransactionsEntity $transactionsEntity): bool;
}
