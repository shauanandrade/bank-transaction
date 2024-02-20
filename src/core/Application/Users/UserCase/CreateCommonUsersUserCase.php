<?php

namespace Core\Application\Users\UserCase;

use Core\Application\Users\Contracts\ICreateCommonUserUserCase;
use Core\Domain\Entities\Users\CommonUsersEntity;
use Core\Domain\Services\Users\Contracts\IUsersService;


class CreateCommonUsersUserCase implements ICreateCommonUserUserCase
{

    public function __construct(private readonly IUsersService $usersService)
    {
    }

    public function execute(array $usersEntity): void
    {
        $commom = CommonUsersEntity::toEntity($usersEntity);
        $this->usersService->createCommonUser($commom);
    }
}
