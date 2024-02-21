<?php

namespace Core\Domain\Contracts;

interface IAuthorisationService
{
    public function authorisation(): bool;
}
