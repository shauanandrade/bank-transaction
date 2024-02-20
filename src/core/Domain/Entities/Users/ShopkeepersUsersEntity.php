<?php

namespace Core\Domain\Entities\Users;

use Core\Domain\Entities\Users\Contracts\IShopkeepersUsersEntity;

class ShopkeepersUsersEntity implements IShopkeepersUsersEntity
{

    public function __construct(
        private string $fullname,
        private string $email,
        private string $password,
        private string $cnpj,
        private float  $wallet = 0.0
    )
    {
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

        if (!$this->cnpj) {
            throw new \Error('Field CNPJ is required.');
        }

        if (!$this->validateCnpj()) {
            throw new \Error('CNPJ is invalid.');
        }

    }

    private function validateCnpj()
    {
        $cnpj = preg_replace('/[^0-9]/', '', (string)$this->getCnpj());

        // Valida tamanho
        if (strlen($cnpj) != 14)
            return false;

        // Verifica se todos os digitos são iguais
        if (preg_match('/(\d)\1{13}/', $cnpj))
            return false;

        // Valida primeiro dígito verificador
        for ($i = 0, $j = 5, $soma = 0; $i < 12; $i++) {
            $soma += $cnpj[$i] * $j;
            $j = ($j == 2) ? 9 : $j - 1;
        }

        $resto = $soma % 11;

        if ($cnpj[12] != ($resto < 2 ? 0 : 11 - $resto))
            return false;

        // Valida segundo dígito verificador
        for ($i = 0, $j = 6, $soma = 0; $i < 13; $i++) {
            $soma += $cnpj[$i] * $j;
            $j = ($j == 2) ? 9 : $j - 1;
        }

        $resto = $soma % 11;

        return $cnpj[13] == ($resto < 2 ? 0 : 11 - $resto);
    }

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

    public function getCnpj(): string
    {
        return $this->cnpj;
    }

    public function setCnpj(string $cnpj): void
    {
        $this->cnpj = $cnpj;
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

    public static function toEntity(array $user): IShopkeepersUsersEntity
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
        return [
            "fullname" => $this->getFullname(),
            "email" => $this->getEmail(),
            "password" => $this->getPassword(),
            "cpf_cnpj" => $this->getCnpj(),
            "wallet" => (float)$this->getWallet(),
        ];
    }
}
