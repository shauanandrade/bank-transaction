<?php

namespace Tests\Entities;

use Core\Domain\Entities\Users\CommonUsersEntity;
use Core\Domain\Entities\Users\ShopkeepersUsersEntity;
use Core\Domain\ValueObjects\CpfCnpj;
use Core\Domain\ValueObjects\Email;
use Core\Domain\ValueObjects\Password;
use PHPUnit\Framework\TestCase;

class ShopkeepersUsersEntitiesTest extends TestCase
{

    public function testInstanceEntity()
    {
        $userEntity = new ShopkeepersUsersEntity(
            "Shopkeepers User",
            new Email("shopkeepers@email.com"),
            new Password("password123"),
            new CpfCnpj('86798316000196'),
            0
        );
        $this->assertInstanceOf(ShopkeepersUsersEntity::class,$userEntity);
        $hash = $userEntity->getPassword()->getValue();
        $this->assertSame(true,$userEntity->getPassword()->verification('password123',$hash));
    }

    public function testExceptionFullName()
    {
        $this->expectExceptionMessage("Field fullname is required and must be at least 3 character.");
        new ShopkeepersUsersEntity(
            "Us",
            new Email("shopkeepers@email.com"),
            new Password("password123"),
            new CpfCnpj('86798316000196'),
            0
        );
    }

    public function testExceptionEmailEmpty()
    {
        $this->expectExceptionMessage("Field email is required.");
        new ShopkeepersUsersEntity(
            "User name",
            new Email(""),
            new Password("password123"),
            new CpfCnpj('86798316000196'),
            0
        );
    }

    public function testExceptionEmailInvalid()
    {
        $this->expectExceptionMessage("Field email invalid.");

        new ShopkeepersUsersEntity(
            "User name",
            new Email("shopkeepers@email"),
            new Password("password123"),
            new CpfCnpj('86798316000196'),
            0
        );
    }

    public function testDeposit()
    {
        $userEntity = new ShopkeepersUsersEntity(
            "User name",
            new Email("shopkeepers@email.com"),
            new Password("password123"),
            new CpfCnpj('86798316000196'),
            0
        );

        $this->assertSame(0.0,$userEntity->getWallet());
        $userEntity->deposit(3000.0);
        $this->assertSame(3000.0,$userEntity->getWallet());

    }

    public function testWithdraw()
    {
        $userEntity = new ShopkeepersUsersEntity(
            "User name",
            new Email("shopkeepers@email.com"),
            new Password("password123"),
            new CpfCnpj('86798316000196'),
            3000
        );

        $this->assertEquals(3000.0, $userEntity->getWallet());
        $isWithdraw = $userEntity->withdraw(1500.0);
        $this->assertSame(true, $isWithdraw);
        $this->assertSame(1500.0, $userEntity->getWallet());

    }

    public function testWithdrawWorthless()
    {
        $userEntity = new ShopkeepersUsersEntity(
            "User name",
            new Email("shopkeepers@email.com"),
            new Password("password123"),
            new CpfCnpj('86798316000196'),
            0
        );

        $this->assertSame(0.0, $userEntity->getWallet());
        $isWithdraw = $userEntity->withdraw(1500);
        $this->assertSame(false, $isWithdraw);

    }
    public function testExceptionCnpjRequired()
    {
        $this->expectExceptionMessage("Field CNPJ is required");

        new ShopkeepersUsersEntity(
            "User name",
            new Email("shopkeepers@email.com"),
            new Password("password123"),
            new CpfCnpj(''),
            0
        );
    }

    public function testExceptionCnpjInvalid()
    {
        $this->expectExceptionMessage("CNPJ is invalid.");

        new ShopkeepersUsersEntity(
            "User name",
            new Email("shopkeepers@email.com"),
            new Password("password123"),
            new CpfCnpj('86798316000192'),
            0
        );
    }
}
