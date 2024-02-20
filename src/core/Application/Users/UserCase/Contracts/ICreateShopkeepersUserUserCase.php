<?php

namespace Core\Application\Users\UserCase\Contracts;


interface ICreateShopkeepersUserUserCase{
    public function execute(array $usersEntity): void;
}
