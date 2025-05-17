<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Gate;
use App\Models\Status;
use App\Policies\StatusPolicy;

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

    }
}
