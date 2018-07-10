<?php
namespace Allfa\PagSeguro;
use Illuminate\Support\ServiceProvider;
class PagSeguroServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind('pagseguro', function ($app) {
            return new PagSeguro($app['log'], $app['validator']);
        });
    }
    public function boot()
    {
        if (!method_exists($this->app, 'routesAreCached')) {
            require __DIR__.'/routes.php';
            return; // lumen
        }
        if (!$this->app->routesAreCached()) {
            require __DIR__.'/routes.php';
        }
        $this->publishes([
            __DIR__.'/Config.php' => config_path('pagseguro.php'),
        ],
        'config');
    }
}