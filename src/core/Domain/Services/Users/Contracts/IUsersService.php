<?php

namespace Core\Domain\Services\Users\Contracts;

use Core\Domain\Entities\Users\Contracts\ICommonUsersEntity;

interface IUsersService
{
    public function findAll(): array;

    public function findCpfOrCnpj(string $cpfOrCnpj): ?ICommonUsersEntity;

    public function createCommonUser(ICommonUsersEntity $commonUser): void;
}
