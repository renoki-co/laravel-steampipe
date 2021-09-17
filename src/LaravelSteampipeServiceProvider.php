<?php

namespace RenokiCo\LaravelSteampipe;

use Illuminate\Support\ServiceProvider;

class LaravelSteampipeServiceProvider extends ServiceProvider
{
    /**
     * Boot the service provider.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->resolving('db', function ($db) {
            $db->extend('steampipe', function ($config, $name) {
                $config['name'] = $name;

                return new SteampipeConnection($config);
            });
        });
    }
}
