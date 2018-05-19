<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Account extends Model
{
    use Notifiable;

<<<<<<< HEAD
    protected $fillable = [
        'owner_id', 'account_type_id', 'date', 'code', 'description', 'start_balance',
    ];
=======
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
>>>>>>> 313818cbef5df7b6aa526497da51e66522fff96b

    public function formatedAccountTypeName()
    {
<<<<<<< HEAD
        switch ($this->account_type_id) {
            case 1:
                return 'Bank account';
            case 2:
                return 'Pocket money';
            case 3:
                return 'PayPal account';
            case 4:
                return 'Credit card';
            case 5:
                return 'Meal card';
        }

        return 'Unknown';
    }
=======
        $accounts = Account::where('owner_id', $user_id)->get();
        return $accounts;
    }


>>>>>>> 313818cbef5df7b6aa526497da51e66522fff96b
}
