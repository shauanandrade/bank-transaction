<?php

namespace Tests\Entities;

use Core\Domain\Entities\Users\CommonUsersEntity;
use Core\Domain\ValueObjects\CpfCnpj;
use Core\Domain\ValueObjects\Email;
use Core\Domain\ValueObjects\Password;
use Faker\Calculator\Ean;
use PHPUnit\Framework\TestCase;

class CommonUsersEntitiesTest extends TestCase
{

    public function testInstanceEntity()
    {
        $userEntity = new CommonUsersEntity(
            "User name",
            new Email("shopkeepers@email.com"),
            new Password("password123"),
            new CpfCnpj('70188041087'),
            0
        );

        $this->assertInstanceOf(CommonUsersEntity::class,$userEntity);
    }

    public function testExceptionFullName()
    {
        $this->expectExceptionMessage("Field fullname is required and must be at least 3 character.");
        new CommonUsersEntity(
            "Us", //invalid fullname
            new Email("shopkeepers@email.com"),
            new Password("password123"),
            new CpfCnpj('70188041087'),
            0
        );
    }

    public function testExceptionCpfRequired()
    {
        $this->expectExceptionMessage("Field CPF is required");

        new CommonUsersEntity(
            "Common User",
            new Email("shopkeepers@email.com"),
            new Password("password123"),
            new CpfCnpj(''), // CpfCnpj is null
            0
        );
    }

    public function testExceptionCpfInvalid()
    {
        $this->expectExceptionMessage("CPF is invalid.");

        new CommonUsersEntity(
            "Common User",
            new Email("shopkeepers@email.com"),
            new Password("password123"),
            new CpfCnpj('70188041012'), // cpf is invalid
            0
        );
    }

    public function testExceptionEmailEmpty()
    {
        $this->expectExceptionMessage("Field email is required.");
        new CommonUsersEntity(
            "User Sk",
            new Email(""),
            new Password("password123"),
            new CpfCnpj('70188041087'),
            0
        );
    }

    public function testExceptionEmailInvalid()
    {
        $this->expectExceptionMessage("Field email invalid.");

        new CommonUsersEntity(
            "User Sk",
            new Email("error_email@email"),
            new Password("password123"),
            new CpfCnpj('70188041087'),
            0
        );
    }

    public function testDeposit()
    {
        $userEntity = new CommonUsersEntity(
            "User name",
            new Email("shopkeepers@email.com"),
            new Password("password123"),
            new CpfCnpj('70188041087'),
            0.0
        );

        $this->assertSame(0.0,$userEntity->getWallet());
        $userEntity->deposit(3000.0);
        $this->assertSame(3000.0,$userEntity->getWallet());

    }

    public function testWithdraw()
    {
        $userEntity = new CommonUsersEntity(
            "User name",
            new Email("shopkeepers@email.com"),
            new Password("password123"),
            new CpfCnpj('70188041087'),
            3000.0
        );

        $this->assertSame(3000.0, $userEntity->getWallet());
        $isWithdraw = $userEntity->withdraw(1500.0);
        $this->assertSame(true, $isWithdraw);
        $this->assertSame(1500.0, $userEntity->getWallet());

    }

    public function testWithdrawWorthless()
    {
        $userEntity = new CommonUsersEntity(
            "User name",
            new Email("shopkeepers@email.com"),
            new Password("password123"),
            new CpfCnpj('70188041087'),
            0
        );

        $this->assertSame(0.0, $userEntity->getWallet());
        $isWithdraw = $userEntity->withdraw(1500);
        $this->assertSame(false, $isWithdraw);

    }
}
