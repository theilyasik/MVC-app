<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Gate;
use App\Models\User;
use App\Models\Session as SalonSession;
use Illuminate\Pagination\Paginator;

class AppServiceProvider extends ServiceProvider
{
    public function boot(): void
{
    Paginator::defaultView('pagination::default');

    Gate::define('edit-session', function (User $user, SalonSession $session) {
        return ($user->is_admin ?? false) || in_array($user->email, ['admin@example.com']);
    });

    Gate::define('delete-session', function (User $user, SalonSession $session) {
        return ($user->is_admin ?? false) || in_array($user->email, ['admin@example.com']);
    });
}

   
}
