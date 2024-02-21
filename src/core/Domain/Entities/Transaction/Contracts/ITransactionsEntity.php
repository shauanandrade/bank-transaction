<?php

namespace Core\Domain\Entities\Transaction\Contracts;

use Core\Domain\Entities\Users\Contracts\ICommonUsersEntity;
use Core\Domain\Entities\Users\Contracts\IShopkeepersUsersEntity;
use Core\Domain\Entities\Users\Contracts\IUsersEntity;

interface ITransactionsEntity
{
    public function getPayer(): ICommonUsersEntity;

    public function getPayee(): ICommonUsersEntity|IShopkeepersUsersEntity|IUsersEntity;

    public function getValue(): float;

    public function getStatus(): string;

    public function setStatus(string $status): void;

    public function makeTransaction(): bool;

    public function revertTransaction(): void;

}
