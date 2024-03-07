<?php

namespace Cms\Modules\Core;

use Cms\Modules\Core\Commands\AddRoleCommand;
use Cms\Modules\Core\Repositories\AccountRepository;
use Cms\Modules\Core\Repositories\Contracts\AccountRepositoryContract;
use Cms\Modules\Core\Repositories\Contracts\NotificationRepositoryContract;
use Cms\Modules\Core\Repositories\Contracts\OrderRepositoryContract;
use Cms\Modules\Core\Repositories\Contracts\PrizeRepositoryContract;
use Cms\Modules\Core\Repositories\Contracts\SiteLogRepositoryContract;
use Cms\Modules\Core\Repositories\Contracts\SiteRepositoryContract;
use Cms\Modules\Core\Repositories\Contracts\UserRepositoryContract;
use Cms\Modules\Core\Repositories\Contracts\WheelEventRepositoryContract;
use Cms\Modules\Core\Repositories\NotificationRepository;
use Cms\Modules\Core\Repositories\OrderRepository;
use Cms\Modules\Core\Repositories\PrizeRepository;
use Cms\Modules\Core\Repositories\SiteLogRepository;
use Cms\Modules\Core\Repositories\SiteRepository;
use Cms\Modules\Core\Repositories\UserRepository;
use Cms\Modules\Core\Repositories\WheelEventRepository;
use Cms\Modules\Core\Services\AccountService;
use Cms\Modules\Core\Services\Contracts\AccountServiceContract;
use Cms\Modules\Core\Services\Contracts\NotificationServiceContract;
use Cms\Modules\Core\Services\Contracts\OrderServiceContract;
use Cms\Modules\Core\Services\Contracts\PrizeServiceContract;
use Cms\Modules\Core\Services\Contracts\SiteLogServiceContract;
use Cms\Modules\Core\Services\Contracts\SiteServiceContract;
use Cms\Modules\Core\Services\Contracts\UserServiceContract;
use Cms\Modules\Core\Services\Contracts\WheelEventServiceContract;
use Cms\Modules\Core\Services\NotificationService;
use Cms\Modules\Core\Services\OrderService;
use Cms\Modules\Core\Services\PrizeService;
use Cms\Modules\Core\Services\SiteLogSerivce;
use Cms\Modules\Core\Services\SiteService;
use Cms\Modules\Core\Services\UserService;
use Cms\Modules\Core\Services\WheelEventService;
use Illuminate\Routing\Router;
use Illuminate\Support\ServiceProvider;
use function foo\func;

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

        if ($this->app->runningInConsole()) {
            $this->commands([
                AddRoleCommand::class,
            ]);
        }

        view()->composer(['Core::layouts.app', 'Core::order.index', 'Core::wheel.event'], 'Cms\Modules\Core\ViewComposer');
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
        $this->app->bind(NotificationRepositoryContract::class, NotificationRepository::class);
        $this->app->bind(NotificationServiceContract::class, NotificationService::class);
        $this->app->bind(SiteRepositoryContract::class, SiteRepository::class);
        $this->app->bind(SiteServiceContract::class, SiteService::class);
        $this->app->bind(SiteLogRepositoryContract::class, SiteLogRepository::class);
        $this->app->bind(SiteLogServiceContract::class, SiteLogSerivce::class);
        $this->app->bind(PrizeRepositoryContract::class, PrizeRepository::class);
        $this->app->bind(PrizeServiceContract::class, PrizeService::class);
        $this->app->bind(WheelEventRepositoryContract::class, WheelEventRepository::class);
        $this->app->bind(WheelEventServiceContract::class, WheelEventService::class);
    }
}
