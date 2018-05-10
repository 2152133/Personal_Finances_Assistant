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
    public $deleted_at;
    public $created_at;

    
}
