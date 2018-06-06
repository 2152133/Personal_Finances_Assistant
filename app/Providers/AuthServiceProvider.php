<?php

namespace App\Providers;

use App\Policies\UserPolicy;
use App\User;
use App\Account;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;


class AuthServiceProvider extends ServiceProvider
{
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

        Gate::define('update', function ($user) {
             return ($user->admin == 0 || $user->admin == 1);
        });

        Gate::define('create', function ($user) {
             return ($user->admin == 0 || $user->admin == 1);
        });

        Gate::define('delete', function ($user) {
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
