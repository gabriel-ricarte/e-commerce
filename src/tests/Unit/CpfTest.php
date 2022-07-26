<?php

namespace Tests\Unit;

use App\Models\Cpf;
use PHPUnit\Framework\TestCase;

class CpfTest extends TestCase
{
    public function testValidCpfWithPunctuation()
    {
        $cpf = new Cpf('071.385.484-78');
        $this->assertEquals('071.385.484-78', $cpf->value, 'Invalid CPF');
    }

    public function testValidCpfWithoutPunctuation()
    {
        $cpf = new Cpf('07138548478');
        $this->assertEquals('07138548478', $cpf->value, 'Invalid CPF');
    }

    public function testInvalidCpfWithoutPunctuation()
    {
        $this->expectError('Invalid CPF');
        new Cpf('07138548473');
    }

    public function testInvalidCpfWithPunctuation()
    {
        $this->expectError('Invalid CPF');
        new Cpf('071.385.484-73');
    }

    public function testInvalidCpfWithIdenticalNumbers()
    {
        $this->expectError('Invalid CPF');
        $cpf = new Cpf('111.111.111-11');
        $this->expectError('Invalid CPF');
        $cpf = new Cpf('222.222.222-22');
        $this->expectError('Invalid CPF');
        $cpf = new Cpf('333.333.333-33');
    }
}
