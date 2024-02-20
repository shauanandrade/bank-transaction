<?php

namespace Core\Application\Users\Contracts;

use Core\Domain\Entities\Users\Contracts\ICommonUsersEntity;

interface IFindByCpfOrCnpjUserCase{
    public function execute(string $cpfOrCnpj);
}
