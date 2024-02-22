<?php

namespace Core\Domain\Entities\Users;

use Core\Domain\Entities\Users\Contracts\IShopkeepersUsersEntity;
use Core\Domain\ValueObjects\CpfCnpj;
use Core\Domain\ValueObjects\Email;
use Core\Domain\ValueObjects\Password;

class ShopkeepersUsersEntity extends UsersEntity implements IShopkeepersUsersEntity
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

        if (!($this->email->getValue())) {
            throw new \Error("Field email is required.");
        }

        if (!$this->cpfCnpj->getValue()) {
            throw new \Error('Field CNPJ is required.');
        } else {
            $this->cpfCnpj->validateCNPJ();
        }


    }

    public static function toEntity(array $user): IShopkeepersUsersEntity
    {
        return new self(
            $user['fullname'],
            new Email($user['email']),
            new Password($user['password']),
            new CpfCnpj($user['cpf_cnpj']),
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
