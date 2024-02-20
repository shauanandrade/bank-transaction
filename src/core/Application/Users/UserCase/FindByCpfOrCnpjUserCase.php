<?php

namespace Core\Application\Users\UserCase;

use Core\Application\Users\UserCase\Contracts\IFindByCpfOrCnpjUserCase;
use Core\Domain\Services\Users\Contracts\IUsersService;

class FindByCpfOrCnpjUserCase implements IFindByCpfOrCnpjUserCase
{
    public function __construct(private readonly IUsersService $usersService)
    {
    }
    public function execute(string $cpfOrCnpj)
    {
        return $this->usersService->findByCpfOrCnpj($cpfOrCnpj);
    }
}
