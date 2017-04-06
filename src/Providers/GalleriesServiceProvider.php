<?php

namespace Mixdinternet\Galleries\Providers;

use Illuminate\Support\ServiceProvider;


class GalleriesServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->setRoutes();

        $this->loadViews();

        $this->loadMigrations();

        $this->loadConfigs();

        $this->publish();
    }

    public function register()
    {

    }

    protected function setRoutes()
    {
        if (!$this->app->routesAreCached()) {
            $this->app->router->group(['namespace' => 'Mixdinternet\Galleries\Http\Controllers'],
                function () {
                    require __DIR__ . '/../routes/web.php';
                    require __DIR__ . '/../routes/api.php';
                });
        }
    }

    protected function loadViews()
    {
        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'mixdinternet/galleries');
    }

    protected function loadMigrations()
    {
        $this->loadMigrationsFrom(__DIR__ . '/../database/migrations');
    }

    protected function loadConfigs()
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/maudit.php', 'maudit.alias');
        $this->mergeConfigFrom(__DIR__ . '/../config/mgalleries.php', 'mgalleries');
    }

    protected function publish()
    {
        $this->publishes([
            __DIR__ . '/../resources/assets' => base_path('resources/assets'),
        ], 'assets');

        $this->publishes([
            __DIR__ . '/../config/mgalleries.php' => base_path('config/mgalleries.php'),
        ], 'config');
    }

}
