<?php

namespace Baas\LaravelVisitorLogger;

use Event;
use Illuminate\Routing\Router;
use Baas\LaravelVisitorLogger\App\Http\Middleware\LogActivity;
use Illuminate\Support\ServiceProvider;


class VisitorLoggerServiceProvider extends ServiceProvider
{

    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    /**
     * The event listener mappings for the applications auth scafolding.
     *
     * @var array
     */
    protected $listeners = [

        'Illuminate\Auth\Events\Attempting' => [
            'Baas\LaravelVisitorLogger\App\Listeners\LogAuthenticationAttempt',
        ],

        'Illuminate\Auth\Events\Authenticated' => [
            'Baas\LaravelVisitorLogger\App\Listeners\LogAuthenticated',
        ],

        'Illuminate\Auth\Events\Login' => [
            'Baas\LaravelVisitorLogger\App\Listeners\LogSuccessfulLogin',
        ],

        'Illuminate\Auth\Events\Failed' => [
            'Baas\LaravelVisitorLogger\App\Listeners\LogFailedLogin',
        ],

        'Illuminate\Auth\Events\Logout' => [
            'Baas\LaravelVisitorLogger\App\Listeners\LogSuccessfulLogout',
        ],

        'Illuminate\Auth\Events\Lockout' => [
            'Baas\LaravelVisitorLogger\App\Listeners\LogLockout',
        ],

        'Illuminate\Auth\Events\PasswordReset' => [
            'Baas\LaravelVisitorLogger\App\Listeners\LogPasswordReset',
        ],

    ];

    /**
     * load routes
     */
    public static function routes()
    {
        require __DIR__ . '/routes/web.php';
    }

    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot(Router $router)
    {
        $router->middlewareGroup('activity', [LogActivity::class]);
        $this->loadTranslationsFrom(__DIR__ . '/resources/lang/', 'LaravelVisitorLogger');
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
//        $this->loadRoutesFrom(__DIR__.'/routes/web.php');
        $this->loadViewsFrom(__DIR__ . '/resources/views/', 'LaravelVisitorLogger');
        $this->loadMigrationsFrom(__DIR__ . '/database/migrations');
        if (file_exists(config_path('laravel-visitor-logger.php'))) {
            $this->mergeConfigFrom(config_path('laravel-visitor-logger.php'), 'LaravelVisitorLogger');
        } else {
            $this->mergeConfigFrom(__DIR__ . '/config/laravel-visitor-logger.php', 'LaravelVisitorLogger');
        }
        $this->registerEventListeners();
        $this->publishFiles();
    }

    /**
     * Register the list of listeners and events.
     *
     * @return void
     */
    private function registerEventListeners()
    {
        $listeners = $this->getListeners();
        foreach ($listeners as $listenerKey => $listenerValues) {
            foreach ($listenerValues as $listenerValue) {
                Event::listen($listenerKey,
                    $listenerValue
                );
            }
        }
    }

    /**
     * Get the list of listeners and events.
     *
     * @return array
     */
    private function getListeners()
    {
        return $this->listeners;
    }

    /**
     * Publish files for Laravel Logger.
     *
     * @return void
     */
    private function publishFiles()
    {
        $publishTag = 'laravelvisitorlogger';

        $this->publishes([
            __DIR__ . '/config/laravel-visitor-logger.php' => base_path('config/laravel-visitor-logger.php'),
        ], $publishTag);

        $this->publishes([
            __DIR__ . '/resources/views' => resource_path('views/vendor/' . $publishTag),
        ], $publishTag);

        $this->publishes([
            __DIR__ . '/resources/lang' => base_path('resources/lang/vendor/' . $publishTag),
        ], $publishTag);

        $this->publishes([
            __DIR__ . '/database/migrations' => database_path('migrations'),
        ], $publishTag);
    }
}
