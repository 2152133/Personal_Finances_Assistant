<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Account extends Model
{
    use Notifiable;

    protected $fillable = [
        'owner_id', 'account_type_id', 'date', 'code', 'description', 'start_balance',
    ];

    public function formatedAccountTypeName()
    {
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
}
