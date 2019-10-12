<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model 
{

    protected $table = 'notifications';
    public $timestamps = true;
    protected $fillable = array('order_id','title' ,'body', 'action', 'notifiiable_id', 'notifiiable_type');

    public function order()
    {
        return $this->belongsTo('App\Model\Order');
    }

    public function notifiiable()
    {
        return $this->morphTo();
    }

}