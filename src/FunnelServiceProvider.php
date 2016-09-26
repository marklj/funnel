<?php namespace Marklj\Funnel;

use Illuminate\Support\ServiceProvider;

class FunnelServiceProvider extends ServiceProvider
{

    public function boot()
    {
        if (! $this->app->routesAreCached()) {
            require __DIR__.'/routes.php';
        }
    }

}