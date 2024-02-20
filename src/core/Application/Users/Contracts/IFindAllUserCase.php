<?php

namespace Core\Application\Users\Contracts;

interface IFindAllUserCase{
    public function execute():array;
}
