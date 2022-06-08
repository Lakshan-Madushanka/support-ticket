<?php

namespace App\Providers;

use App\Models\User;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rules\Password;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
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
        $this->gates();
        $this->passwordDefaultRules();
    }

    public function gates()
    {
        Gate::define('supportAgent', function (User $user) {
            return self::allowSupportAgent($user);
        });
    }

    public static function allowSupportAgent(User $user)
    {
        return $user->role_id === User::ROLES['SUPPORT_AGENT'];
    }

    public function passwordDefaultRules()
    {
        Password::defaults(function () {
            $rule = Password::min(6)
                ->letters()
                ->symbols()
                ->mixedCase()
                ->uncompromised();

            return $this->app->isProduction()
                ? $rule
                : Password::min(6);
        });
    }
}
