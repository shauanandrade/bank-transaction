<?php

namespace Core\Domain\Entities\Users\Contracts;

interface IUsersEntity
{
    public function getId(): int;
    public function getFullname(): string;
    public function getEmail(): string;
    public function getPassword(): string;
    public function getWallet(): float;
    public function getCpfCnpj(): string;
    public function deposit(float $value): void;
    public function withdraw(float $value): bool;
    public static function toEntity(array $user): mixed;
    public function toArray(): array;
}
