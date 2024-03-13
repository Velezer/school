<?php

namespace App\Providers;

use App\Services\UserService;
use App\View\Components\LayoutMenuComponent;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(UserService::class, function () {
            return new UserService();
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
        // Blade::component('layout-menu-component', LayoutMenuComponent::class);
    }
}
