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
     * @var array<class-string, class-string>
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
        \App\Models\Model\User::class => \App\Policies\UserPolicy::class,
        \App\Models\Model\Book::class => \App\Policies\BookPolicy::class,
        \App\Models\Model\Author::class => \App\Policies\AuthorPolicy::class,
        \App\Models\Model\Category::class => \App\Policies\CategoryPolicy::class,
        \App\Models\Model\Review::class => \App\Policies\ReviewPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Gate::define('admin', function (User $user) {
            return $user->level >= 2;
        });

        Gate::define('atleast_moderator', function (User $user) {
            return $user->level >= 1;
        });
    }
}
