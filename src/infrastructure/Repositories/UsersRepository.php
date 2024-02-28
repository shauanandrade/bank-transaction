<?php

namespace Infrastructure\Repositories;

use App\Models\User;
use Core\Domain\Entities\Users\Contracts\ICommonUsersEntity;
use Core\Domain\Entities\Users\Contracts\IShopkeepersUsersEntity;
use Core\Domain\Repositories\IUserRepository;

class UsersRepository implements IUserRepository
{
    public function findAll(): array
    {
        $users = User::all();
        return $users->toArray();
    }

    public function saveCommonUser(ICommonUsersEntity $commonUser): void
    {
        $createCommonUser = $commonUser->toArray();
        User::create($createCommonUser);
    }

    public function findByCpfOrCnpj(string $cpf_cnpj): array
    {
        return User::where('cpf_cnpj', $cpf_cnpj)->get()->toArray();
    }

    public function findByEmail(string $email): ?array
    {
        return User::where('email', $email)->get()->toArray();
    }

    public function saveShopkeeperUser(IShopkeepersUsersEntity $shopkeepersUser): void
    {
        $createShopkeeperUser = $shopkeepersUser->toArray();
        User::create($createShopkeeperUser);
    }

    public function updateWallet(string $cpfOrCnpj, float $value): void
    {
        User::where('cpf_cnpj', $cpfOrCnpj)->update(['wallet' => $value]);
    }

    public function findById(int $id): ?array
    {
        return User::where('id',$id)->get()->toArray();
    }
}
