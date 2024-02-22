<?php

namespace Core\Domain\Services\Users;

use Core\Domain\Entities\Users\CommonUsersEntity;
use Core\Domain\Entities\Users\Contracts\ICommonUsersEntity;
use Core\Domain\Entities\Users\Contracts\IShopkeepersUsersEntity;
use Core\Domain\Repositories\IUserRepository;
use Core\Domain\Services\Users\Contracts\IUsersService;

class UsersService implements IUsersService
{
    public function __construct(private readonly IUserRepository $userRepository)
    {
    }

    public function findAll(): array
    {
        return $this->userRepository->findAll();
    }

    public function createCommonUser(ICommonUsersEntity $commonUser): void
    {
        $existCpf = $this->findByCpfOrCnpj($commonUser->getCpfCnpj());
        if($existCpf){
            throw new \Error('CpfCnpj exists in database');
        }

        $existEmail = $this->findByEmail($commonUser->getEmail());

        if($existEmail){
            throw new \Error('Email exists in database');
        }

        $this->userRepository->saveCommonUser($commonUser);
    }

    public function findByCpfOrCnpj(string $cpfOrCnpj): ?array
    {

        $user = $this->userRepository->findByCpfOrCnpj($cpfOrCnpj);
        if(!(isset($user[0]) && $user[0]))
            return null;

        return $user[0];
    }

    public function findByEmail(string $email): ?array
    {
        $user = $this->userRepository->findByEmail($email);
        if(!(isset($user[0]) && $user[0]))
            return null;

        return $user[0];
    }

    public function createShopKeepersUser(IShopkeepersUsersEntity $shopkeepersUsers): void
    {
        $existCpf = $this->findByCpfOrCnpj($shopkeepersUsers->getCpfCnpj());
        if($existCpf){
            throw new \Error('CNPJ exists in database');
        }

        $existEmail = $this->findByEmail($shopkeepersUsers->getEmail());

        if($existEmail){
            throw new \Error('Email exists in database');
        }

        $this->userRepository->saveShopkeeperUser($shopkeepersUsers);
    }
}
