<?php

namespace SamuelNitsche\AuthLog;

use Illuminate\Contracts\Events\Dispatcher;
use Illuminate\Support\ServiceProvider;

class AuthLogServiceProvider extends ServiceProvider
{
    use EventMap;

    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerEvents();

        $this->loadViewsFrom(__DIR__.'/../resources/views', 'auth-log');

        $this->loadTranslationsFrom(__DIR__.'/../resources/lang', 'auth-log');

        $this->mergeConfigFrom(__DIR__.'/../config/auth-log.php', 'auth-log');

        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__.'/../database/migrations' => database_path('migrations'),
            ], 'auth-log-migrations');

            $this->publishes([
                __DIR__.'/../resources/views' => resource_path('views/vendor/auth-log'),
            ], 'auth-log-views');

            $this->publishes([
                __DIR__.'/../resources/lang' => resource_path('lang/vendor/auth-log'),
            ], 'auth-log-translations');

            $this->publishes([
                __DIR__.'/../config/auth-log.php' => config_path('auth-log.php'),
            ], 'auth-log-config');
        }
    }

    /**
     * Register the Auth Log's events.
     *
     * @return void
     */
    protected function registerEvents()
    {
        $events = $this->app->make(Dispatcher::class);

        foreach ($this->events as $event => $listeners) {
            foreach ($listeners as $listener) {
                $events->listen($event, $listener);
            }
        }
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                Console\ClearCommand::class,
            ]);
        }
    }
}
