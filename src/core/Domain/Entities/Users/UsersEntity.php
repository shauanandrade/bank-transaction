<?php

namespace Core\Domain\Entities\Users;

use Core\Domain\Entities\Users\Contracts\IUsersEntity;
use Core\Domain\ValueObjects\CpfCnpj;
use Core\Domain\ValueObjects\Email;
use Core\Domain\ValueObjects\Password;

class UsersEntity implements IUsersEntity
{
    protected int $id = 0;
    protected string $fullname;
    protected Email $email;
    protected CpfCnpj $cpfCnpj;
    protected Password $password;
    protected float $wallet = 0.0;
    public function getId(): int
    {
        return $this->id;
    }

    public function setId(string $id): void
    {
        $this->id = $id;
    }
    public function getFullname(): string
    {
        return $this->fullname;
    }

    public function setFullname(string $fullname): void
    {
        $this->fullname = $fullname;
    }

    public function getEmail(): Email
    {
        return $this->email;
    }

    public function setEmail(string $email): void
    {
        $this->email = new Email($email);
    }

    public function getPassword(): Password
    {
        return $this->password;
    }

    public function setPassword(string $password): void
    {
        $this->password = new Password($password);
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


    public static function toEntity(array $user): mixed
    {
        return null;
    }

    public function toArray(): array
    {
        return [];
    }

    public function getCpfCnpj(): CpfCnpj
    {
        return $this->cpfCnpj;
    }

    public function setCpfCnpj(string $cpfCnpj): void
    {
        $this->cpfCnpj = new CpfCnpj($cpfCnpj);
    }
}
