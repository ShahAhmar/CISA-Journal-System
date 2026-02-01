<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    protected $policies = [
        //
    ];

    public function boot(): void
    {
        Gate::define('access-admin', function ($user) {
            $role = strtolower(trim($user->role ?? ''));
            return in_array($role, ['admin', 'super-admin', 'administrator'], true);
        });
    }
}

