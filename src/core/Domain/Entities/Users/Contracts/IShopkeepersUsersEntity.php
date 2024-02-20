<?php

namespace Core\Domain\Entities\Users\Contracts;

interface IShopkeepersUsersEntity extends IUsersEntity
{
    public function getCnpj(): string;
}
