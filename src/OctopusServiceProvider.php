<?php

namespace unaspbr;

use Illuminate\Support\ServiceProvider;

/**
 * Octopus ─ A package integrating Octopus with laravel 5.* framework applications
 *
 * @author Mateus Felipe <mateusfccp@gmail.com>
 * @package Octopus
 * @version 1.0.3
 */
class OctopusServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return  void
     */
    public function boot()
    {
        // Publish configuration assets
        $this->publishes([
            __DIR__ . '/config/octopus.php' => config_path('octopus.php'),
        ]);
    }

    /**
     * Register the application services.
     *
     * @return  void
     */
    public function register()
    {
        $this->app->singleton(Octopus::class, function($app) {
            return Octopus::class;
        });
    }
}
