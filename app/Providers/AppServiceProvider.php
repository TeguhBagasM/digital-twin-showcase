<?php

namespace App\Providers;

use App\Models\Showcase;
use App\Policies\ShowcasePolicy;
use Illuminate\Support\Facades\Gate;
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
     * In Laravel 11, policy registration goes here (no separate AuthServiceProvider needed).
     */
    public function boot(): void
    {
        // Register Showcase policy for data isolation
        Gate::policy(Showcase::class, ShowcasePolicy::class);
    }
}
