<?php
// app/Providers/AppServiceProvider.php
namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Gate;

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
        Gate::define('is_admin', function ($user) {
            return $user->isAdmin();
        });

        Gate::define('investor-access', function ($user) {
            return $user->isInvestor();
        });

        Gate::define('entrepreneur-access', function ($user) {
            return $user->isEntrepreneur();
        });


    }
}
