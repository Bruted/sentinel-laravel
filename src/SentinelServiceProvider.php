<?php

namespace Redeyed\LaravelSentinel;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\ServiceProvider;
use Redeyed\LaravelSentinel\Rules\Sentinel as SentinelRule;

class SentinelServiceProvider extends ServiceProvider
{
    /**
     * Register package services.
     */
    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/sentinel.php', 'sentinel');

        $this->app->singleton(SentinelVerifier::class, fn () => new SentinelVerifier());
    }

    /**
     * Bootstrap package services.
     */
    public function boot(): void
    {
        // Publishable config.
        $this->publishes([
            __DIR__ . '/../config/sentinel.php' => config_path('sentinel.php'),
        ], 'sentinel-config');

        // Views + the anonymous <x-sentinel-captcha /> component.
        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'sentinel');
        Blade::anonymousComponentPath(__DIR__ . '/../resources/views', 'sentinel');
        Blade::component('sentinel::widget', 'sentinel-captcha');

        // @sentinel Blade directive (renders the same widget view).
        Blade::directive('sentinel', function () {
            return "<?php echo view('sentinel::widget')->render(); ?>";
        });

        // 'sentinel' validation rule alias.
        Validator::extend('sentinel', function ($attribute, $value, $parameters, $validator) {
            $passes = true;

            (new SentinelRule())->validate($attribute, $value, function () use (&$passes) {
                $passes = false;
            });

            return $passes;
        }, 'Human verification failed — please try again.');
    }
}
