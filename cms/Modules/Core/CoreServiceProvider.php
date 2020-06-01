<?php

namespace Cms\Modules\Core;

use Cms\Modules\Core\Repositories\Contracts\UserRepositoryContract;
use Cms\Modules\Core\Repositories\UserRepository;
use Cms\Modules\Core\Services\Contacts\UserServiceContract;
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
    }
}
