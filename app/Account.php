<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Account extends Model
{
    use Notifiable;

    protected $fillable = [
        'owner_id', 'account_type_id', 'date', 'code', 'description', 'start_balance',
    ];
}
