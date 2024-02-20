<?php

namespace Core\Domain\Entities\Users\Contracts;

interface IUsersEntity
{
    public function getFullname(): string;
    public function getEmail(): string;
    public function getPassword(): string;
    public function getWallet(): float;
    public function deposit(float $value): void;
    public static function toEntity(array $user): self;
    public function toArray(): array;
}
