<?php

namespace App\Providers;

use App\Models\User;
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
        // 'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Gate::before(function ($user, $ability) {
            if ($user instanceof User) {
                if ($user['role'] == 'admin') {
                    return $user['role'] == $ability;
                } elseif ($user['role'] == 'dosen') {
                    return $user['role'] == $ability;
                } else {
                    return $user['role'] == $ability;
                }
            } else {
                return false;
            }
        });
    }
}
