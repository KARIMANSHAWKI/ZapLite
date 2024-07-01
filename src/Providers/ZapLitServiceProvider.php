<?php

namespace ZapLite\Providers;

use Illuminate\Support\ServiceProvider;

class ZapLitServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->mergeConfigFrom(
            __DIR__ . '/../config/config.php', 'config');
    }

    public function boot()
    {
        $this->publishes([
            __DIR__ . '/../config/config.php' => __DIR__ . '/../config/config.php',
        ]);
    }
}