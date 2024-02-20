<?php

namespace Core\Domain\Entities\Users;

use Core\Domain\Entities\Users\Contracts\ICommonUsersEntity;

class CommonUsersEntity implements ICommonUsersEntity
{
    private string $fullname;
    private string $cpf;
    private string $email;
    private string $password;
    private float $wallet;

    public function __construct(
        string $fullname,
        string $email,
        string $password,
        string $cpf,
        float  $wallet = 0.0
    )
    {
        $this->fullname = $fullname;
        $this->cpf = $cpf;
        $this->email = $email;
        $this->password = $password;
        $this->wallet = $wallet ?? 0.0;
        $this->validate();
    }

    private function validate(): void
    {
        if (!($this->fullname && strlen($this->fullname) >= 3)) {
            throw new \Error("Field fullname is required and must be at least 3 character.");
        }

        if (!($this->email)) {
            throw new \Error("Field email is required.");
        }

        if (filter_var($this->email, FILTER_VALIDATE_EMAIL) === false) {
            throw new \Error("Field email invalid.");
        }

        if (!$this->cpf) {
            throw new \Error("Field CPF is required");
        }

        if (!$this->validateCPF()) {
            throw new \Error("CPF is invalid.");
        }

    }

    public function validateCPF(): bool
    {
        $cpf = preg_replace('/[^0-9]/is', '', $this->cpf);

        if (strlen($cpf) != 11) {
            return false;
        }

        if (preg_match('/(\d)\1{10}/', $cpf)) {
            return false;
        }

        for ($t = 9; $t < 11; $t++) {
            for ($d = 0, $c = 0; $c < $t; $c++) {
                $d += $cpf[$c] * (($t + 1) - $c);
            }
            $d = ((10 * $d) % 11) % 10;
            if ($cpf[$c] != $d) {
                return false;
            }
        }
        return true;
    }

    public function getFullname(): string
    {
        return $this->fullname;
    }

    public function setFullname(string $fullname): void
    {
        $this->fullname = $fullname;
    }

    public function getCpf(): string
    {
        return $this->cpf;
    }

    public function setCpf(string $cpf): void
    {
        $this->cpf = $cpf;
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

    public function transfer(float $value, ICommonUsersEntity $recipient): bool
    {
        if ($this->withdraw($value)) {
            $recipient->deposit($value);
            return true;
        }
        return false;
    }

    public static function toEntity(array $commonUser): self
    {
        return new self(
            $commonUser['fullname'],
            $commonUser['email'],
            $commonUser['password'],
            $commonUser['cpf_cnpj'],
            $commonUser['wallet'] ?? 0.0,
        );
    }

    public function toArray(): array
    {
        return [
            "fullname" => $this->getFullname(),
            "email" => $this->getEmail(),
            "password" => $this->getPassword(),
            "cpf_cnpj" => $this->getCpf(),
            "wallet" => (float) $this->getWallet(),
        ];
    }
}
