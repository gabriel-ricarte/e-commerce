<?php

namespace App\Models;

use Error;

class Cpf
{
    private const FIRST_DIGIT_FACTOR = 10;
	private const SECOND_DIGIT_FACTOR = 11;
    public String $value;

    function __construct(String $value)
    {
        if (!$this->validate($value)) throw new Error("Invalid CPF");
        $this->value = $value;
    }

    private function validate(String $rawCpf) : Bool
    {
        if (trim($rawCpf) == "") return false;
        $cpf = $this->cleanCpf($rawCpf);
        if ($this->isInvalidLength($cpf)) return false;
        if ($this->isIdentical($cpf)) return false;
        $calculatedCheckDigit1 = $this->calculateCheckDigit($cpf, self::FIRST_DIGIT_FACTOR);
		$calculatedCheckDigit2 = $this->calculateCheckDigit($cpf, self::SECOND_DIGIT_FACTOR);
        $checkDigit = $this->extractCheckDigits($cpf);
		$calculatedCheckDigit = $calculatedCheckDigit1.$calculatedCheckDigit2;
		return $checkDigit === $calculatedCheckDigit; 
    }

    private function cleanCpf(String $cpf) : String 
    {
       return preg_replace('/[^0-9]/s', '', $cpf);
    }

    private function isInvalidLength(String $cpf) : Bool
    {
        return strlen($cpf) !== 11;
    }

    private function isIdentical(String $cpf) : Bool
    {
        for ($i = 1; $i < 11; $i++)
            if ($cpf[$i] != $cpf[0])
                return false;
     
        return true;
    }

    private function calculateCheckDigit(String $cpf, Int $factor) : Int
    {
        $total = 0;
        foreach (str_split($cpf) as $digit)
        {
            if ($factor > 1) $total += (int)$digit * $factor--;
        }
        $rest = $total%11;
        return ($rest < 2) ? 0 : 11 - $rest;
    }

    private function extractCheckDigits (String $cpf) {
		return substr($cpf, -2, 2);
	}
}
