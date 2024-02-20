<?php

namespace App\Providers;

use App\Infrastructure\Repositories\UsersRepository;
use Core\Application\Users\Contracts\ICreateCommonUserUserCase;
use Core\Application\Users\Contracts\IFindAllUserCase;
use Core\Application\Users\Contracts\IFindByCpfOrCnpjUserCase;
use Core\Application\Users\UserCase\CreateCommonUsersUserCase;
use Core\Application\Users\UserCase\FindAllUserCase;
use Core\Application\Users\UserCase\FindByCpfOrCnpjUserCase;
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
        $this->app->singleton(IFindAllUserCase::class,function($app){
            $userRepository = new UsersRepository();
            $userService = new UsersService($userRepository);
            return new FindAllUserCase($userService);
        });
        $this->app->singleton(IFindByCpfOrCnpjUserCase::class,function($app){
            $userRepository = new UsersRepository();
            $userService = new UsersService($userRepository);
            return new FindByCpfOrCnpjUserCase($userService);
        });
        $this->app->singleton(ICreateCommonUserUserCase::class,function($app){
            $userRepository = new UsersRepository();
            $userService = new UsersService($userRepository);
            return new CreateCommonUsersUserCase($userService);
        });
    }
}
