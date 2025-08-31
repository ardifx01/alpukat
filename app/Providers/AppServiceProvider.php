<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Gate;
use Illuminate\Pagination\Paginator;
use App\Models\User;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        // View pagination Bootstrap 5
        Paginator::useBootstrapFive();

        // Definisikan Gate bernama 'admin'
        Gate::define('admin', fn(User $u) => $u->user_type === 'admin');
    }
}
