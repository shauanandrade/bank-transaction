<?php

namespace Tests\Entities;

use Core\Domain\Entities\Users\CommonUsersEntity;
use PHPUnit\Framework\TestCase;

class ShopkeepersUsersEntitiesTest extends TestCase
{

    public function testInstanceEntity()
    {
        $userEntity = new CommonUsersEntity(
            "User name",
            "shopkeepers@email.com",
            "password123",
            '20202002020202',
            0
        );
        $this->assertInstanceOf(CommonUsersEntity::class,$userEntity);
    }

    public function testExceptionFullName()
    {
        $this->expectExceptionMessage("Field fullname is required and must be at least 3 character.");
        new CommonUsersEntity(
            "Us", //invalid fullname
            "shopkeepers@email.com",
            "password123",
            '20202002020202',
            0
        );
    }

    public function testExceptionEmailEmpty()
    {
        $this->expectExceptionMessage("Field email is required.");
        new CommonUsersEntity(
            "User Sk",
            "",
            "password123",
            '20202002020202',
            0
        );
    }

    public function testExceptionEmailInvalid()
    {
        $this->expectExceptionMessage("Field email invalid.");

        new CommonUsersEntity(
            "User Sk",
            "error_email@email",
            "password123",
            '20202002020202',
            0
        );
    }

    public function testDeposit()
    {
        $userEntity = new CommonUsersEntity(
            "User name",
            "shopkeepers@email.com",
            "password123",
            '20202002020202',
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
            "shopkeepers@email.com",
            "password123",
            '021234121213',
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
            "shopkeepers@email.com",
            "password123",
            '021234121213',
            0
        );

        $this->assertSame(0.0, $userEntity->getWallet());
        $isWithdraw = $userEntity->withdraw(1500);
        $this->assertSame(false, $isWithdraw);

    }

    public function testTransfer()
    {
        $user1 = new CommonUsersEntity(
            "User name",
            "shopkeepers@email.com",
            "password123",
            '021234121213',
            300
        );
        $user2 = new CommonUsersEntity(
            "User name2",
            "shopkeepers2@email.com",
            "password123",
            '021234121213',
            0
        );

        $this->assertSame(300.0, $user1->getWallet());
        $this->assertSame(0.0, $user2->getWallet());
        $isSuccess = $user1->transfer(140.50,$user2);
        $this->assertSame($isSuccess,true);
        $this->assertSame(159.50, $user1->getWallet());
        $this->assertSame(140.50, $user2->getWallet());
    }

    public function testTransferError()
    {
        $user1 = new CommonUsersEntity(
            "User name",
            "shopkeepers@email.com",
            "password123",
            '021234121213',
            300.0
        );
        $user2 = new CommonUsersEntity(
            "User name2",
            "shopkeepers2@email.com",
            "password123",
            '021234121213',
            0
        );

        $this->assertSame(300.0, $user1->getWallet());
        $this->assertSame(0.0, $user2->getWallet());
        $isSuccess = $user1->transfer(400.0,$user2);
        $this->assertSame($isSuccess,false);
        $this->assertSame(300.0, $user1->getWallet());
        $this->assertSame(0.0, $user2->getWallet());
    }
}
