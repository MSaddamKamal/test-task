<?php

namespace App\Modules\DemoTest\Providers;

use App\Modules\DemoTest\Contracts\DemoTestInquiryServiceContract;
use App\Modules\DemoTest\Contracts\DemoTestServiceContract;
use App\Modules\DemoTest\Services\DemoTestInquiryService;
use App\Modules\DemoTest\Services\DemoTestService;
use Illuminate\Support\ServiceProvider;


class DemoTestBootServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        // binding  service interface to service concrete class, for decoupling
        $this->app->bind(DemoTestInquiryServiceContract::class , DemoTestInquiryService::class);
        $this->app->bind(DemoTestServiceContract::class , DemoTestService::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        // booting migrations
        $this->loadMigrationsFrom(__DIR__.'/../database/migrations');
        // booting routes
        $this->loadRoutesFrom(__DIR__.'/../routes/api.php');
        // booting config
        $this->mergeConfigFrom(__DIR__.'/../config/demotest.php', 'demotest');
        // booting translations
        $this->loadTranslationsFrom(__DIR__.'/../lang', 'demotest');

    }
}
