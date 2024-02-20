<?php

namespace Core\Domain\Entities\Users;

class ShopkeepersUsersEntity
{
    private string $fullname;
    private string $cnpj;
    private string $email;
    private string $password;
    private float $wallet;

    public function __construct(
        string $fullname,
        string $email,
        string $password,
        string $cnpj,
        float  $wallet = 0.0
    )
    {
        $this->fullname = $fullname;
        $this->cnpj = $cnpj;
        $this->email = $email;
        $this->password = $password;
        $this->wallet = $wallet;
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

        if (filter_var($this->email,FILTER_VALIDATE_EMAIL) === false) {
            throw new \Error("Field email invalid.");
        }

    }

    public function getWallet(): float
    {
        return $this->wallet;
    }

    public function deposit(float $value): void
    {
        $this->wallet += $value;
    }

}
