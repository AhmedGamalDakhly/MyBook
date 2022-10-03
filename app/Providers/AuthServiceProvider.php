<?php

namespace App\Providers;

use App\Group;
use App\Policies\PostPolicy;
use App\Policies\GroupPolicy;
use App\Policies\ProfilePolicy;
use App\Content;
use App\Profile;
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
            Content::class => PostPolicy::class,
            Group::class => GroupPolicy::class,
            Profile::class => ProfilePolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {

        $this->registerPolicies();
        //
    }
}
