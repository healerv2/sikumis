<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Carbon\Carbon;
use App\Models\Settings;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
        view()->composer('layouts.master', function ($view) {
            $view->with('settings', Settings::first());
        });
        view()->composer('layouts.auth', function ($view) {
            $view->with('settings', Settings::first());
        });
        view()->composer('login.index', function ($view) {
            $view->with('settings', Settings::first());
        });
        view()->composer('login.register', function ($view) {
            $view->with('settings', Settings::first());
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
        config(['app.locale' => 'id']);
        Carbon::setLocale('id');
    }
}
