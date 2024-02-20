<?php

namespace Core\Domain\Services\Users\Contracts;

use Core\Domain\Entities\Users\Contracts\ICommonUsersEntity;
use Core\Domain\Entities\Users\Contracts\IShopkeepersUsersEntity;

interface IUsersService
{
    public function findAll(): array;

    public function findByCpfOrCnpj(string $cpfOrCnpj): ?array;
    public function findByEmail(string $email): ?array;

    public function createCommonUser(ICommonUsersEntity $commonUser): void;
    public function createShopKeepersUser(IShopkeepersUsersEntity $shopkeepersUsers): void;
}
