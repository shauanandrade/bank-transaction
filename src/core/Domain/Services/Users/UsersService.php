<?php

namespace Core\Domain\Services\Users;

use Core\Domain\Entities\Users\CommonUsersEntity;
use Core\Domain\Entities\Users\Contracts\ICommonUsersEntity;
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
        $exitCpf = $this->findCpfOrCnpj($commonUser->getCpf());
        dd($exitCpf);
        if($exitCpf?->exists === true){
            throw new \Error('CPF exists in database');
        }

        $this->userRepository->saveCommonUser($commonUser);
    }

    public function findCpfOrCnpj(string $cpfOrCnpj): ?ICommonUsersEntity
    {

        $user = $this->userRepository->findCpfOrCnpj($cpfOrCnpj);

        $entity = new CommonUsersEntity();

//        $entity->enti
        return $user[0];
    }
}
