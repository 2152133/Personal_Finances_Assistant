<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Account extends Model
{
    public $id;
    public $owner_id;
    public $account_type_id;
    public $date;
    public $code;
    public $description;
    public $start_balance;
    public $current_balance;
    public $last_movement_date;

    public function __construct(array $attributes = [])
    {
        foreach ($attributes as $name => $value) {
            $this->$name = $value;
        }
    }

    public static function allAccounts()
    {
        $accounts = Account::get();

        return $accounts;
    }

    public static function accountsFromUser($user_id)
    {
        $accounts = Account::where('owner_id', $user_id)->get();
        return $accounts;
    }


}
