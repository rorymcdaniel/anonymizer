<?php

namespace Rorymcdaniel\Anonymizer;

use Illuminate\Support\ServiceProvider;
use Rorymcdaniel\Anonymizer\Console\Commands\AnonymizeUsersCommand;

class AnonymizerServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     */
    public function boot()
    {
        /*
         * Optional methods to load your package assets
         */
        // $this->loadTranslationsFrom(__DIR__.'/../resources/lang', 'anonymizer');
        // $this->loadViewsFrom(__DIR__.'/../resources/views', 'anonymizer');
        // $this->loadMigrationsFrom(__DIR__.'/../database/migrations');
        // $this->loadRoutesFrom(__DIR__.'/routes.php');

        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__.'/../config/config.php' => config_path('anonymizer.php'),
            ], 'config');

            // Publishing the views.
            /*$this->publishes([
                __DIR__.'/../resources/views' => resource_path('views/vendor/anonymizer'),
            ], 'views');*/

            // Publishing assets.
            /*$this->publishes([
                __DIR__.'/../resources/assets' => public_path('vendor/anonymizer'),
            ], 'assets');*/

            // Publishing the translation files.
            /*$this->publishes([
                __DIR__.'/../resources/lang' => resource_path('lang/vendor/anonymizer'),
            ], 'lang');*/

            // Registering package commands.
            $this->commands([
                AnonymizeUsersCommand::class,
            ]);
        }
    }

    /**
     * Register the application services.
     */
    public function register()
    {
        // Automatically apply the package configuration
        $this->mergeConfigFrom(__DIR__.'/../config/config.php', 'anonymizer');

        // Register the main class to use with the facade
        $this->app->singleton('anonymizer', function () {
            return new Anonymizer;
        });
    }
}
