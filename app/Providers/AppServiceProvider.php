<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Gate;
use App\Models\Status;
use App\Policies\StatusPolicy;
use App\Models\User;
use App\Policies\UserPolicy;

class AppServiceProvider extends ServiceProvider
{
    protected $policies = [
        Status::class => StatusPolicy::class,
    ];
    public function register(): void
    {
        //
    }



    public function boot(): void
    {
        // Register the StatusPolicy
        Gate::policy(Status::class, StatusPolicy::class);
        Gate::define('destroy-status', function ($user, $status) {
            return $user->id === $status->user_id;
        });

        Gate::policy(User::class, UserPolicy::class);
        Gate::define('update-user', function ($user, $model) {
            return $user->id === $model->id || $user->is_admin;
        });
        Gate::define('destroy-user', function ($user, $model) {
            return $user->id === $model->id || $user->is_admin;
        });
        Gate::define('follow', function ($user, $model) {
            return $user->id !== $model->id;
        });


    }
}
