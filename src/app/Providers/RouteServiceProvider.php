<?php

namespace App\Providers;

use App\Infrastructure\Adapters\AuthorisationAdapter;
use App\Infrastructure\Adapters\NotificationAdapter;
use App\Infrastructure\Repositories\TransactionRepository;
use App\Infrastructure\Repositories\UsersRepository;
use Core\Application\Transactions\UserCase\Contracts\IMakeTransactionUseCase;
use Core\Application\Transactions\UserCase\MakeTransactionUserCase;
use Core\Application\Users\UserCase\Contracts\ICreateCommonUserUserCase;
use Core\Application\Users\UserCase\Contracts\ICreateShopkeepersUserUserCase;
use Core\Application\Users\UserCase\Contracts\IFindAllUserCase;
use Core\Application\Users\UserCase\Contracts\IFindByCpfOrCnpjUserCase;
use Core\Application\Users\UserCase\CreateCommonUsersUserCase;
use Core\Application\Users\UserCase\CreateShopkeeperUsersUserCase;
use Core\Application\Users\UserCase\FindAllUserCase;
use Core\Application\Users\UserCase\FindByCpfOrCnpjUserCase;
use Core\Domain\Services\Transactions\TransactionService;
use Core\Domain\Services\Users\UsersService;
use Illuminate\Support\ServiceProvider;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(IFindAllUserCase::class, function ($app) {
            $userRepository = new UsersRepository();
            $userService = new UsersService($userRepository);
            return new FindAllUserCase($userService);
        });
        $this->app->singleton(IFindByCpfOrCnpjUserCase::class, function ($app) {
            $userRepository = new UsersRepository();
            $userService = new UsersService($userRepository);
            return new FindByCpfOrCnpjUserCase($userService);
        });
        $this->app->singleton(ICreateCommonUserUserCase::class, function ($app) {
            $userRepository = new UsersRepository();
            $userService = new UsersService($userRepository);
            return new CreateCommonUsersUserCase($userService);
        });
        $this->app->singleton(ICreateShopkeepersUserUserCase::class, function ($app) {
            $userRepository = new UsersRepository();
            $userService = new UsersService($userRepository);
            return new CreateShopkeeperUsersUserCase($userService);
        });
        $this->app->singleton(IMakeTransactionUseCase::class, function ($app) {
            $transactionRepo = new TransactionRepository();
            $userRepository = new UsersRepository();
            $autorization = new AuthorisationAdapter();
            $notificaiton = new NotificationAdapter();
            $transactionService = new TransactionService($transactionRepo, $userRepository, $autorization, $notificaiton);
            return new MakeTransactionUserCase($transactionService);
        });
    }
}
