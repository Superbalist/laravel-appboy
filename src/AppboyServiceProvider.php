<?php

namespace Superbalist\LaravelAppboy;

use GuzzleHttp\Client;
use Illuminate\Support\ServiceProvider;
use Superbalist\Appboy\Appboy;

class AppboyServiceProvider extends ServiceProvider
{
    /**
     * Perform post-registration booting of services.
     */
    public function boot()
    {
        $this->publishes([
            __DIR__ . '/../config/appboy.php' => config_path('appboy.php'),
        ]);
    }

    /**
     * Register bindings in the container.
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/appboy.php', 'appboy');

        $this->app->bind(Appboy::class, function ($app) {
            $client = new Client();
            $config = $app['config']['appboy'];
            return new Appboy($client, $config['app_group_id'], $config['uri']);
        });

        $this->app->bind('appboy', Appboy::class);
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [
            'appboy',
        ];
    }
}
