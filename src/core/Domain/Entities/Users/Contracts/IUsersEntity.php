<?php

namespace Core\Domain\Entities\Users\Contracts;

use Core\Domain\ValueObjects\CpfCnpj;
use Core\Domain\ValueObjects\Email;
use Core\Domain\ValueObjects\Password;

interface IUsersEntity
{
    public function getId(): int;
    public function getFullname(): string;
    public function getEmail(): Email;
    public function getPassword(): Password;
    public function getWallet(): float;
    public function getCpfCnpj(): CpfCnpj;
    public function deposit(float $value): void;
    public function withdraw(float $value): bool;
    public static function toEntity(array $user): mixed;
    public function toArray(): array;
}
