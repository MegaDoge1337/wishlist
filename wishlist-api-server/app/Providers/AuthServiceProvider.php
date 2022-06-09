<?php

namespace App\Providers;

use App\Models\User;
use App\Models\Wish;
use Illuminate\Auth\Access\Response;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Gate::define('wish-belongs-to-user', function (User $user, Wish $wish) {
            if($user->id == $wish->user_id) {
                return Response::allow();
            }
            return Response::deny();
        });
    }
}
