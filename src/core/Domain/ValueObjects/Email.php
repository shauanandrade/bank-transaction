<?php

namespace Core\Domain\ValueObjects;

final class Email
{
    private string $email;
    public function __construct(string $value)
    {
        if (!$value) {
            throw new \Error("Field email is required.");
        }
        if (filter_var($value, FILTER_VALIDATE_EMAIL) === false) {
            throw new \Error("Field email invalid.");
        }

        $this->email = $value;
    }

    public function isValid():bool
    {
        return filter_var($this->email, FILTER_VALIDATE_EMAIL);
    }

    public function getValue():string
    {
        return $this->email;
    }
    public function __toString()
    {
        return $this->email;
    }
}
