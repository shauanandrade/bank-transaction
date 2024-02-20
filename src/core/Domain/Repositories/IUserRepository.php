<?php
namespace Core\Domain\Repositories;
use Core\Domain\Entities\Users\CommonUsersEntity;
use Core\Domain\Entities\Users\Contracts\ICommonUsersEntity;

interface IUserRepository
{
    public function findAll(): array;
    public function saveCommonUser(ICommonUsersEntity $common_user): void;
    public function findCpfOrCnpj(string $cpf_cnpj): array;
    /* public function findByCPFOrCNPJ(string $cpf_cnpj): CommonUsersEntity|ShopkeepersUsersEntity|null;
     public function findByEmail(string $email): CommonUsersEntity|ShopkeepersUsersEntity|null;
     public function saveShopkeepers(ShopkeepersUsersEntity $shopkeepers): void;*/
}
