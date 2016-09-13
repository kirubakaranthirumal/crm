<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Laraveldaily\Quickadmin\Observers\UserActionsObserver;


use Illuminate\Database\Eloquent\SoftDeletes;

class Tickets extends Model {

    use SoftDeletes;

    /**
    * The attributes that should be mutated to dates.
    *
    * @var array
    */
    protected $dates = ['deleted_at'];

    protected $table    = 'tickets';
    
    protected $fillable = ['ticket_id'];
    

    public static function boot()
    {
        parent::boot();

        Tickets::observe(new UserActionsObserver);
    }
    
    
    
    
}