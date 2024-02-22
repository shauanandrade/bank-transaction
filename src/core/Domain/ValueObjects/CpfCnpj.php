<?php

namespace Core\Domain\ValueObjects;

final class CpfCnpj
{
    private string $cpfCnpj;

    public function __construct(string $value)
    {
        $this->cpfCnpj = $value;
    }

    public function validateCPF(): void
    {
        if (!$this->isValidCPF($this->cpfCnpj)) {
            throw new \Error("CPF is invalid.");
        }
    }

    public function isValidCPF(string $value): bool{
        $cpf = preg_replace('/[^0-9]/is', '', $value);

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

    public function getValue()
    {
        return $this->cpfCnpj;
    }

    public function isCpf():bool
    {
        return $this->isValidCPF($this->cpfCnpj);
    }

    public function validateCNPJ(): void{
        if (!$this->isValidCNPJ($this->cpfCnpj)) {
            throw new \Error("CNPJ is invalid.");
        }
    }
    public function isValidCNPJ(string $value): bool{
        $cnpj = preg_replace('/[^0-9]/', '', $value);

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

    public function __toString(): string
    {
        return $this->cpfCnpj;
    }
}
