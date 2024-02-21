<?php
namespace Core\Domain\Repositories;
use Core\Domain\Entities\Users\CommonUsersEntity;
use Core\Domain\Entities\Users\Contracts\ICommonUsersEntity;
use Core\Domain\Entities\Users\Contracts\IShopkeepersUsersEntity;

interface IUserRepository
{
    public function findAll(): array;
    public function saveCommonUser(ICommonUsersEntity $commonUser): void;
    public function saveShopkeeperUser(IShopkeepersUsersEntity $shopkeepersUser): void;
    public function findByCpfOrCnpj(string $cpfOrCnpj): ?array;
    public function findByEmail(string $email): ?array;
    public function findById(int $id): ?array;
    public function updateWallet(string $cpfOrCnpj,float $value): void;
    /* public function findByCPFOrCNPJ(string $cpf_cnpj): CommonUsersEntity|ShopkeepersUsersEntity|null;
     public function findByEmail(string $email): CommonUsersEntity|ShopkeepersUsersEntity|null;
     public function saveShopkeepers(ShopkeepersUsersEntity $shopkeepers): void;*/
}
