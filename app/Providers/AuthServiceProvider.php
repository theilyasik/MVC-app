<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use App\Models\User;
use App\Models\Session as SalonSession;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     * @var array<class-string, class-string>
     */
    protected $policies = [
        // Маппинги policy, если будут нужны
    ];

    /**
     * Register any authentication / authorization services.
     */
     public function boot(): void
    {
        // Настройка шаблона пагинации
        Paginator::defaultView('pagination::default');
    }
}
