<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Register LogObserver untuk semua model utama
        \App\Models\User::observe(\App\Observers\LogObserver::class);
        \App\Models\Role::observe(\App\Observers\LogObserver::class);
        \App\Models\Menu::observe(\App\Observers\LogObserver::class);
        \App\Models\RoleMenu::observe(\App\Observers\LogObserver::class);
        \App\Models\DeliveryOrder::observe(\App\Observers\LogObserver::class);
        \App\Models\Departemen::observe(\App\Observers\LogObserver::class);
    }
}
