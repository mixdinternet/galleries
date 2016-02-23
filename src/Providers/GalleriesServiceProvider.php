<?php

namespace Mixdinternet\Galleries\Providers;

use Illuminate\Support\ServiceProvider;


class GalleriesServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        if (!$this->app->routesAreCached()) {
            $this->app->router->group(['namespace' => 'Mixdinternet\Galleries\Http\Controllers'],
                function () {
                    require __DIR__ . '/../Http/routes.php';
                });
        }

        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'mixdinternet/galleries');

        $this->publishes([
            __DIR__ . '/../resources/assets' => base_path('resources/assets'),
        ], 'assets');

        $this->publishes([
            __DIR__ . '/../resources/views' => base_path('resources/views/vendor/mixdinternet/galleries'),
        ], 'views');

        $this->publishes([
            __DIR__ . '/../database/migrations' => base_path('database/migrations'),
        ], 'migrations');

    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {

    }
}
