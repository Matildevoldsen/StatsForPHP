<?php

namespace StatsPHP\Providers;

use Illuminate\Support\ServiceProvider;
use StatsPHP\Services\StatsService;

class StatsPHPServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(StatsService::class, function ($app) {
            return new StatsService();
        });
    }
}
