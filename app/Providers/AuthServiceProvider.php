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
            //dd($this->accountOwnerId($account_id).$account_id.$user->associatedTo);
            //dd($user->associatedTo->toArray()[0]['id'] == $this->accountOwnerId($account_id));
            return $user->id == $this->accountOwnerId($account_id) || $user->associatedTo->toArray()[0]['id'] == $this->accountOwnerId($account_id);
        });

        Gate::define('view-user-accounts', function ($user, $userIWantToSee_id) {
            $associatedToIds = [];

            foreach ($user->associatedTo as $userImaAssociatedTo) {
                array_push($associatedToIds, $userImaAssociatedTo->id);
            }
            
            return (in_array($userIWantToSee_id, $associatedToIds) || ($user->id == $userIWantToSee_id));
        });

        Gate::define('edit-delete-user-accounts', function ($user, $userIWantToSee_id) {
            return ($user->id == $userIWantToSee_id);
        });

        Gate::define('edit-account', function ($user, $account_id) {
            return ($user->id == $this->accountOwnerId($account_id));
        });
    }

    public function accountOwnerId($account_id){
        $account = Account::find($account_id);
        return $account['owner_id'];
    }
}
