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
                    return true;
                } elseif ($user['role'] == 'dosen') {
                    if ($user['role'] == $ability)
                        return true;
                    return false;
                } elseif ($user['role'] == 'mahasiswa') {
                    if ($user['role'] == $ability)
                        return true;
                    return false;
                } else {
                    return false;
                }
            } else {
                return false;
            }
        });
    }
}
