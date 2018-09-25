<?php

namespace Octopus;

use Illuminate\Support\ServiceProvider;

/**
 * Octopus ─ A package integrating Octopus with laravel 5.* framework applications
 *
 * @author Mateus Felipe <mateusfccp@gmail.com>
 * @package Octopus
 * @version 0.1.0
 */
class PlivoServiceProvider extends ServiceProvider
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
        if (method_exists(\Illuminate\Foundation\Application::class, 'singleton')) {
            $this->app->singleton('octopus', function($app) {
                return new Octopus;
            });
        } else {
            $this->app['octopus'] = $this->app->share(function($app) {
                return new Octopus;
            });
        }
    }
}
