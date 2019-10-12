<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model 
{

    protected $table = 'payments';
    public $timestamps = true;
    protected $fillable = array('restaurant_id', 'note', 'amount');

    public function restaurant()
    {
        return $this->belongsTo('App\Model\Restaurant');
    }

}