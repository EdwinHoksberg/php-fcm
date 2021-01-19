<?php

namespace Fcm\Laravel;

use Fcm\FcmClient;
use Illuminate\Contracts\Support\DeferrableProvider;
use Illuminate\Support\ServiceProvider;

class FcmServiceProvider extends ServiceProvider implements DeferrableProvider
{
    public function boot(): void
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__.'/stubs/config.php' => config_path('php-fcm.php'),
            ], 'php-fcm');
        }
    }

    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__.'/stubs/config.php', 'php-fcm');

        $this->app->singleton(FcmClient::class, function () {
            return new FcmClient(
                config('php-fcm.key'), 
                config('php-fcm.sender_id'),
                [
                    'http_errors' => config('php-fcm.http_errors'),
                ]
            );
        });
    }

    public function provides(): array
    {
        return [FcmClient::class];
    }
}
