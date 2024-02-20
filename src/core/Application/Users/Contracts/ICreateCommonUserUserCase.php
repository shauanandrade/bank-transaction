<?php

namespace Core\Application\Users\Contracts;


interface ICreateCommonUserUserCase{
    public function execute(array $usersEntity): void;
}
