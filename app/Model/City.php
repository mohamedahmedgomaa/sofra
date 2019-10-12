<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class City extends Model 
{

    protected $table = 'cities';
    public $timestamps = true;
    protected $fillable = array('name');

    public function neighborhoods()
    {
        return $this->hasMany('App\Model\Neighborhood');
    }

}