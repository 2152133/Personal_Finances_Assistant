<?php

namespace App\Providers;

use App\Policies\UserPolicy;
use App\User;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use App\Account;


class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        User::class => UserPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Gate::define('administrate', function ($user) {
            return $user->admin == 1;
        });

        Gate::define('resgisted', function ($user) {
            return ($user->admin == 0 || $user->admin == 1);
        });

        Gate::define('view-account-movements', function ($user, $account_id) {
            //dd($this->accountOwnerId($account_id));
            return $user->id == $this->accountOwnerId($account_id);
        });
    }

    public function accountOwnerId($account_id){
        $accounts = Account::where('id', $account_id)->get();
        $account = $accounts[0];
        return $account['owner_id'];
    }
}
