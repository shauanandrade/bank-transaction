<?php

namespace App\Infrastructure\Repositories;

use App\Models\User;
use Core\Domain\Entities\Users\CommonUsersEntity;
use Core\Domain\Entities\Users\Contracts\ICommonUsersEntity;
use Core\Domain\Repositories\IUserRepository;

class UsersRepository implements IUserRepository
{
    public function findAll(): array
    {
        $users = User::all();
        return $users->toArray();
    }

    public function saveCommonUser(ICommonUsersEntity $common_user): void
    {
        $createCommonUser = $common_user->toArray();
        User::create($createCommonUser);
    }

    public function findCpfOrCnpj(string $cpf_cnpj): array
    {
        $user = User::where('cpf_cnpj',$cpf_cnpj)->get()->toArray();
        return $user;
    }
}
