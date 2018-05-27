<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Movement extends Model
{
    public $timestamps = false;
    
    protected $fillable = [
        'account_id', 'movement_category_id', 'date', 'value', 'start_balance', 'end_balance', 'description', 'type', 'document_id'

    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        
    ];
}
