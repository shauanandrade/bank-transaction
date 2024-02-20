<?php

namespace Core\Application\Users\UserCase;

use Core\Application\Users\UserCase\Contracts\ICreateCommonUserUserCase;
use Core\Application\Users\UserCase\Contracts\ICreateShopkeepersUserUserCase;
use Core\Domain\Entities\Users\CommonUsersEntity;
use Core\Domain\Entities\Users\ShopkeepersUsersEntity;
use Core\Domain\Services\Users\Contracts\IUsersService;


class CreateShopkeeperUsersUserCase implements ICreateShopkeepersUserUserCase
{

    public function __construct(private readonly IUsersService $usersService)
    {
    }

    public function execute(array $usersEntity): void
    {
        $shopkeeper = ShopkeepersUsersEntity::toEntity($usersEntity);
        $this->usersService->createShopKeepersUser($shopkeeper);
    }
}
