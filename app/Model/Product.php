<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Product extends Model 
{

    protected $table = 'products';
    public $timestamps = true;
    protected $fillable = array('name', 'description', 'price', 'offer', 'time', 'image', 'restaurant_id');

    public function restaurant()
    {
        return $this->belongsTo('App\Model\Restaurant');
    }

    public function orders()
    {
        return $this->belongsToMany('App\Model\Order');
    }

}