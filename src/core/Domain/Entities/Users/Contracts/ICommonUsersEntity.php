<?php

namespace Core\Domain\Entities\Users\Contracts;

interface ICommonUsersEntity extends IUsersEntity
{
    public function getCpf(): string;
    public function withdraw(float $value): bool;
    public function transfer(float $value, ICommonUsersEntity $recipient): bool;
}
