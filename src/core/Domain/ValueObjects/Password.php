<?php

namespace Core\Domain\ValueObjects;

final class Password
{
    private string $password_hash;
    private string $password;

    private array $option = [
        'cost'=>12
    ];

    public function __construct(string $value)
    {
        $this->password_hash = password_hash($value,PASSWORD_BCRYPT);
        $this->password = $value;
    }

    public function getValue(): string
    {
        return $this->password_hash;
    }

    public function verification(string $password, string $hash): bool
    {
        return password_verify($password,$hash);
    }
    public function __toString(): string
    {
        return $this->password_hash;
    }
}
