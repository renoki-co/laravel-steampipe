<?php

namespace RenokiCo\LaravelSteampipe\Test;

use Orchestra\Testbench\TestCase as Orchestra;

abstract class TestCase extends Orchestra
{
    /**
     * {@inheritdoc}
     */
    protected function setUp(): void
    {
        parent::setUp();
    }

    /**
     * {@inheritdoc}
     */
    protected function getPackageProviders($app)
    {
        return [
            \RenokiCo\LaravelSteampipe\LaravelSteampipeServiceProvider::class,
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function getEnvironmentSetUp($app)
    {
        $app['config']->set('app.key', 'wslxrEFGWY6GfGhvN9L3wH3KSRJQQpBD');
        $app['config']->set('auth.providers.users.model', Models\User::class);
        $app['config']->set('database.default', 'steampipe');
        $app['config']->set('database.connections.steampipe', [
            'driver' => 'steampipe',
            'binary' => env('STEAMPIPE_BINARY', 'steampipe'),
        ]);
    }
}
