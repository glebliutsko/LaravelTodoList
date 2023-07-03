<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;
use App\Models\TaskList;
use App\Models\User;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        //
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        Gate::define('tasklist', function (User $user, TaskList $tasklist) {
            return $user->id === $tasklist->user_id;
        });
    }
}
