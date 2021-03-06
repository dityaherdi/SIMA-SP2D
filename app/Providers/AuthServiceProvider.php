<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Gate::define('isMaster', function($user) {
            return $user->tipe == 'Master';
        });
        
        Gate::define('isAdmin', function($user) {
            return $user->tipe === 'Admin';
        });
        
        Gate::define('isPimpinan', function($user) {
            return $user->tipe === 'Pimpinan';
        });

        Gate::define('isMasterOrAdmin', function($user) {
            return $user->tipe == 'Master' || $user->tipe == 'Admin';
        });

        Gate::define('isMasterOrPimpinan', function($user) {
            return $user->tipe == 'Master' || $user->tipe == 'Pimpinan';
        });
    }
}
