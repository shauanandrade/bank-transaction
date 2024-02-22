<?php

namespace Core\Domain\Entities\Transaction;

use Core\Domain\Entities\Transaction\Contracts\ITransactionsEntity;
use Core\Domain\Entities\Users\Contracts\ICommonUsersEntity;
use Core\Domain\Entities\Users\Contracts\IShopkeepersUsersEntity;
use Core\Domain\Entities\Users\Contracts\IUsersEntity;

class TransactionsEntity implements ITransactionsEntity
{
    private string $status;

    public function __construct(
        private readonly ICommonUsersEntity $payer,
        private readonly IUsersEntity       $payee,
        private float                       $value,
    )
    {
        $this->validate();
    }

    private function validate()
    {
        if ($this->value <= 0) {
            throw new \Error('The past and invalid value.');
        }
    }

    public function getPayer(): ICommonUsersEntity
    {
        return $this->payer;
    }

    public function getPayee(): ICommonUsersEntity|IShopkeepersUsersEntity|IUsersEntity
    {
        return $this->payee;
    }

    public function makeTransaction(): bool
    {
        if ($this->payer->getWallet() >= $this->value) {

            $this->payer->withdraw($this->value);

            $this->payee->deposit($this->value);

            $this->setStatus('approved');
            return true;
        }
        return false;
    }

    public function revertTransaction(): void
    {
        $this->payer->deposit($this->value);
        $this->payee->withdraw($this->value);
        $this->setStatus('denied');
    }

    public function getValue(): float
    {
        return $this->value;
    }

    public function setValue(float $value): void
    {
        $this->value = $value;
    }

    public function getStatus(): string
    {
        return $this->status;
    }

    public function setStatus(string $status): void
    {
        $this->status = $status;
    }
}
