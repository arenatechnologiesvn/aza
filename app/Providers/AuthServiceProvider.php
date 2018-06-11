<?php

namespace App\Providers;

use App\Policies\UserPolicy;
use App\User;
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
        User::class => UserPolicy::class
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();
//        Gate::resource('posts', 'App\Policies\PostPolicy');
//        $this->registerUserPolicies();
        //Passport::routes();
        //
    }
    public function registerUserPolicies()
    {
//        Gate::define('create', function ($user) {
//            return User::where('id', $user->id)->hasAccess(['create']);
//        });
//        Gate::define('update-post', function ($user, Post $post) {
//            return $user->hasAccess(['update-post']) or $user->id == $post->user_id;
//        });
//        Gate::define('publish-post', function ($user) {
//            return $user->hasAccess(['publish-post']);
//        });
//        Gate::define('see-all-drafts', function ($user) {
//            return $user->inRole('editor');
//        });
    }
}
