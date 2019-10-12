<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Offer extends Model 
{

    protected $table = 'offers';
    public $timestamps = true;
    protected $fillable = array('name', 'content', 'image', 'from', 'to', 'restaurant_id');

    public function restaurant()
    {
        return $this->belongsTo('App\Model\Restaurant');
    }

}