<?php

namespace Core\Application\Users\UserCase\Contracts;

interface IFindByCpfOrCnpjUserCase{
    public function execute(string $cpfOrCnpj);
}
