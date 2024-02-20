<?php

namespace Core\Application\Users\UserCase;

use Core\Application\Users\UserCase\Contracts\IFindAllUserCase;
use Core\Domain\Services\Users\Contracts\IUsersService;

class FindAllUserCase implements IFindAllUserCase
{
    public function __construct(private readonly IUsersService $usersService)
    {
    }
    public function execute(): array
    {
        return $this->usersService->findAll();
    }
}
