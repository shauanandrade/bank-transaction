<?php

namespace Core\Domain\Entities\Users;

use Core\Domain\Entities\Users\Contracts\IUsersEntity;

class UsersEntity implements IUsersEntity
{
    protected string $fullname;
    protected string $email;

    protected string $cpfCnpj;

    protected string $password;
    protected float $wallet = 0.0;

    public function getFullname(): string
    {
        return $this->fullname;
    }

    public function setFullname(string $fullname): void
    {
        $this->fullname = $fullname;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): void
    {
        $this->password = $password;
    }

    public function getWallet(): float
    {
        return $this->wallet;
    }

    public function setWallet(float $wallet): void
    {
        $this->wallet = $wallet;
    }

    public function deposit(float $value): void
    {
        $this->wallet += $value;
    }

    public function withdraw(float $value): bool
    {
        if ($value <= $this->wallet) {
            $this->wallet -= $value;
            return true;
        }

        return false;
    }


    public static function toEntity(array $user): IUsersEntity
    {
        return new self(
            $user['fullname'],
            $user['email'],
            $user['password'],
            $user['cpf_cnpj'],
            $user['wallet'] ?? 0.0,
        );
    }

    public function toArray(): array
    {
        return [];
    }

    public function getCpfCnpj(): string
    {
        return $this->cpfCnpj;
    }

    public function setCpfCnpj(string $cpfCnpj): void
    {
        $this->cpfCnpj = $cpfCnpj;
    }
}
