<?php

namespace Tests\Services;

use Core\Domain\Repositories\IUserRepository;
use Core\Domain\Services\Users\UsersService;
use PHPUnit\Framework\TestCase;

class UserServiceTest extends TestCase
{
    public function testFindAllCommonUsers(){
        $userRepositoryMock = $this->createMock(IUserRepository::class);

        $userRepositoryMock->expects($this->once())
            ->method('findAll')
            ->willReturn(['teste','teste1']);

        $userService = new UsersService($userRepositoryMock);

        $users = $userService->findAll();
        $this->assertEquals(['teste','teste1'],$users);
    }
}
