<?php

namespace App\Providers;

use App\Models\Session as SalonSession;
use App\Models\User;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        Paginator::useBootstrapFour();

        Gate::define('edit-session', function (User $user, SalonSession $session): bool {
            return $this->userCanManageSessions($user);
        });

        Gate::define('delete-session', function (User $user, SalonSession $session): bool {
            return $this->userCanManageSessions($user);
        });
    }

    private function userCanManageSessions(User $user): bool
    {
        if ($user->is_admin ?? false) {
            return true;
        }
   
        return in_array($user->email, [
            'admin@example.com',
            'admin@beauty-salon.test',
        ], true);
    }
}