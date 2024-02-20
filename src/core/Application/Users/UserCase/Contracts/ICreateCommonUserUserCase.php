<?php

namespace Core\Application\Users\UserCase\Contracts;


interface ICreateCommonUserUserCase{
    public function execute(array $usersEntity): void;
}
