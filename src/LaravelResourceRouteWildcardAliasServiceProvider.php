<?php

namespace AriMahmudRana\laravelResourceRouteWildcardAlias;

use Illuminate\Support\ServiceProvider;

class LaravelResourceRouteWildcardAliasServiceProvider extends ServiceProvider
{
    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('Illuminate\Routing\ResourceRegistrar', function ($app) {
            return new ResourceRegistrar($app['router']);
        });
    }
}
