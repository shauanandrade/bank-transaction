<?php

namespace Core\Domain\Entities\Users\Contracts;

interface ICommonUsersEntity
{
    public function getFullname(): string;
    public function getCpf(): string;
    public function getEmail(): string;
    public function getPassword(): string;
    public function getWallet(): float;
    public function deposit(float $value): void;
    public function withdraw(float $value): bool;
    public function transfer(float $value, ICommonUsersEntity $recipient): bool;
    public static function toEntity(array $commonUser): self;
    public function toArray(): array;
}
