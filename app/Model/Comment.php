<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model 
{

    protected $table = 'comments';
    public $timestamps = true;
    protected $fillable = array('evaluate', 'comment', 'client_id', 'restaurant_id');

    public function client()
    {
        return $this->belongsTo('App\Model\Client');
    }

    public function restaurant()
    {
        return $this->belongsTo('App\Model\Restaurant');
    }

}