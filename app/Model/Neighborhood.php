<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Neighborhood extends Model 
{

    protected $table = 'neighborhoods';
    public $timestamps = true;
    protected $fillable = array('name','city_id');

    public function city()
    {
        return $this->belongsTo('App\Model\City');
    }

    public function restaurants()
    {
        return $this->hasMany('App\Model\Restaurant');
    }

    public function clients()
    {
        return $this->hasMany('App\Model\Client');
    }

}