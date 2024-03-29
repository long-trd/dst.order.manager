<?php

namespace Cms;

use Cms\Modules\Core\Commands\CmsSetupCommand;
use Cms\Modules\Core\CoreServiceProvider;
use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;
use File;

class CmsServiceProvider extends ServiceProvider
{
    /**
     * The application's route middleware.
     *
     * These middleware may be assigned to groups or used individually.
     *
     * @var array
     */
    protected $routeMiddleware = [];

    /**
     * Bootstrap services.
     *
     * @param \Illuminate\Routing\Router $router
     *
     * @return void
     */
    public function boot(Router $router)
    {
        // SPECIFIED KEY WAS TOO LONG ERROR OLD MYSQL SERVER
        Schema::defaultStringLength(191);

        // FORCE SSL
        if(config('app.force_ssl'))
            URL::forceScheme('https');

        // CORE HELPER AUTOLOAD
        if (file_exists(__DIR__ . '/helpers.php'))
            include __DIR__ . '/helpers.php';

        // CMS
        $modulesDIR = __DIR__ . '/Modules';
        $modules = array_map('basename', File::directories($modulesDIR));
        foreach ($modules as $module) {
            $routePath = $modulesDIR  . '/' . $module . '/routes.php';
            $viewPath = $modulesDIR . '/' . $module . '/Views';
            $migrationPath = $modulesDIR . '/' . $module . '/Database/Migrations';
            $configPath = $modulesDIR . '/' . $module . '/Config';

            // MODULE HELPER AUTOLOAD
            if (file_exists($modulesDIR . '/' . $module . '/helpers.php'))
                include $modulesDIR . '/' . $module . '/helpers.php';

            // LOAD MODULES ROUTES
            if (file_exists($routePath))
                $this->loadRoutesFrom($routePath);

            // LOAD MODULES VIEW
            if (is_dir($viewPath))
                $this->loadViewsFrom($viewPath, $module);

            // LOAD MODULES MIGRATION
            if (is_dir($migrationPath))
                $this->loadMigrationsFrom($migrationPath);

            // LOAD MODULES CONFIG (WILL BE OVERRIDE LARAVEL CONFIG)
            if (is_dir($configPath)) {
                $configFiles = scandir($configPath);
                foreach ($configFiles as $config) {
                    if (pathinfo($config, PATHINFO_EXTENSION) === 'php') {
                        $key  = basename($config, '.php');
                        $path = $configPath . '/' . $config;

                        if (!$this->app->runningInConsole()) {
                            if (!$this->app->configurationIsCached()) {
                                $this->app['config']->set($key, require $path);
                            }
                        } else {
                            $argv = \Request::server('argv');
                            if (count($argv) > 1 && $argv[1] === 'config:cache') {
                                $this->app['config']->set($key, require $path);
                            }
                        }
                    }
                }
            }
        }

        // CMS MIDDLEWARE REGISTER
        foreach($this->routeMiddleware as $name => $class) {
            $router->aliasMiddleware($name, $class);
        }

        // CMS COMMAND REGISTER
        if ($this->app->runningInConsole()) {
            $this->commands([
                CmsSetupCommand::class
            ]);
        }
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->register(CoreServiceProvider::class);
    }
}
