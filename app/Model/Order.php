<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Order extends Model 
{

    protected $table = 'orders';
    public $timestamps = true;
    protected $fillable = array('note', 'state', 'restaurant_id', 'price', 'delivery', 'commission', 'total', 'address', 'payment_method_id','qty','note');

    public function products()
    {
        return $this->belongsToMany('App\Model\Product')->withPivot('qty', 'note', 'price');
    }

    public function notifications()
    {
        return $this->hasMany('App\Model\Notification');
    }

    public function client()
    {
        return $this->belongsTo('App\Model\Client');
    }

    public function restaurant()
    {
        return $this->belongsTo('App\Model\Restaurant');
    }

    public function paymentMethod()
    {
        return $this->belongsTo('App\Model\PaymentMethod');
    }

}