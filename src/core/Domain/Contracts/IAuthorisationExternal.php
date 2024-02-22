<?php

namespace Core\Domain\Contracts;

interface IAuthorisationExternal
{
    public function authorisation(): bool;
}
