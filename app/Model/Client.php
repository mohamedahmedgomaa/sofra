<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Client extends Authenticatable
{

    protected $table = 'clients';
    public $timestamps = true;
    protected $fillable = array('name', 'email', 'phone', 'image','is_active', 'password', 'neighborhood_id', 'api_token', 'pin_code');

    public function comments()
    {
        return $this->hasMany('App\Model\Comment');
    }

    public function neighborhood()
    {
        return $this->belongsTo('App\Model\Neighborhood');
    }

    public function tokens()
    {
        return $this->morphMany('App\Model\Token', 'tokenable');
    }

    public function notifications()
    {
        return $this->morphMany('App\Model\Notification', 'notifiiable');
    }

    public function orders()
    {
        return $this->hasMany('App\Model\Order');
    }

    protected $hidden = [
        'password' , 'api_token' , 'pin_code'
    ];

}