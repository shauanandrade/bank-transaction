<?php

namespace Core\Domain\Entities\Users;

use Core\Domain\Entities\Users\Contracts\ICommonUsersEntity;

class CommonUsersEntity extends UsersEntity implements ICommonUsersEntity
{
    public function __construct(
        protected string $fullname,
        protected string $email,
        protected string $password,
        protected string $cpfCnpj,
        protected float  $wallet = 0.0
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

        if (!$this->cpfCnpj) {
            throw new \Error("Field CPF is required");
        }

        if (!$this->validateCPF()) {
            throw new \Error("CPF is invalid.");
        }

    }

    public function validateCPF(): bool
    {
        $cpf = preg_replace('/[^0-9]/is', '', $this->getCpfCnpj());

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

    public static function toEntity(array $user): self
    {
        return new self(
            $user['fullname']??'',
            $user['email']??'',
            $user['password']??'',
            $user['cpf_cnpj']??'',
            $user['wallet'] ?? 0.0,
        );
    }

    public function toArray(): array
    {
        return [
            "id" => $this->getId(),
            "fullname" => $this->getFullname(),
            "email" => $this->getEmail(),
            "password" => $this->getPassword(),
            "cpf_cnpj" => $this->getCpfCnpj(),
            "wallet" => (float)$this->getWallet(),
        ];
    }
}
