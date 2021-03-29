<?php

namespace Cms\Modules\Core;

use Cms\Modules\Core\Repositories\AccountRepository;
use Cms\Modules\Core\Repositories\Contracts\AccountRepositoryContract;
use Cms\Modules\Core\Repositories\Contracts\OrderRepositoryContract;
use Cms\Modules\Core\Repositories\Contracts\UserRepositoryContract;
use Cms\Modules\Core\Repositories\OrderRepository;
use Cms\Modules\Core\Repositories\UserRepository;
use Cms\Modules\Core\Services\AccountService;
use Cms\Modules\Core\Services\Contracts\AccountServiceContract;
use Cms\Modules\Core\Services\Contracts\OrderServiceContract;
use Cms\Modules\Core\Services\Contracts\UserServiceContract;
use Cms\Modules\Core\Services\OrderService;
use Cms\Modules\Core\Services\UserService;
use Illuminate\Routing\Router;
use Illuminate\Support\ServiceProvider;

class CoreServiceProvider extends ServiceProvider
{
    /**
     * The application's route middleware.
     *
     * These middleware may be assigned to groups or used individually.
     *
     * @var array
     */
    protected $routeMiddleware = [
        'cms.guest' => \Cms\Modules\Core\Middleware\RedirectIfAuthenticated::class,
        'cms.verified' => \Cms\Modules\Core\Middleware\EnsureEmailIsVerified::class,
        'role' => \Zizaco\Entrust\Middleware\EntrustRole::class,
        'permission' => \Zizaco\Entrust\Middleware\EntrustPermission::class,
        'ability' => \Zizaco\Entrust\Middleware\EntrustAbility::class,
    ];

    /**
     * Bootstrap services.
     *
     * @param \Illuminate\Routing\Router $router
     *
     * @return void
     */
    public function boot(Router $router)
    {
        // MODULE MIDDLEWARE REGISTER
        foreach($this->routeMiddleware as $name => $class) {
            $router->aliasMiddleware($name, $class);
        }
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(UserRepositoryContract::class, UserRepository::class);
        $this->app->bind(UserServiceContract::class, UserService::class);
        $this->app->bind(AccountRepositoryContract::class, AccountRepository::class);
        $this->app->bind(AccountServiceContract::class, AccountService::class);
        $this->app->bind(OrderServiceContract::class, OrderService::class);
        $this->app->bind(OrderRepositoryContract::class, OrderRepository::class);
    }
}
