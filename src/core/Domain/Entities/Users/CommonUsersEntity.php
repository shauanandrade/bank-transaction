<?php

namespace Core\Domain\Entities\Users;

use Core\Domain\Entities\Users\Contracts\ICommonUsersEntity;
use Core\Domain\ValueObjects\CpfCnpj;
use Core\Domain\ValueObjects\Email;
use Core\Domain\ValueObjects\Password;

class CommonUsersEntity extends UsersEntity implements ICommonUsersEntity
{
    public function __construct(
        protected string   $fullname,
        protected Email    $email,
        protected Password $password,
        protected CpfCnpj  $cpfCnpj,
        protected float    $wallet = 0.0
    )
    {
        $this->validate();
    }

    private function validate(): void
    {
        if (!($this->fullname && strlen($this->fullname) >= 3)) {
            throw new \Error("Field fullname is required and must be at least 3 character.");
        }

        if (!$this->cpfCnpj->getValue()) {
            throw new \Error("Field CPF is required");
        }else {
            $this->cpfCnpj->validateCPF();
        }

    }


    public static function toEntity(array $user): self
    {
        return new self(
            $user['fullname'] ?? '',
            new Email($user['email']) ?? '',
            new Password($user['password']) ?? '',
            new CpfCnpj($user['cpf_cnpj'])??'',
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
            "cpf_cnpj" => $this->getCpfCnpj()->getValue(),
            "wallet" => (float)$this->getWallet(),
        ];
    }
}
