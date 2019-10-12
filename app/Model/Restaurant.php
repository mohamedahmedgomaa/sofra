<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Restaurant extends Authenticatable
{

    protected $table = 'restaurants';
    public $timestamps = true;
    protected $fillable = array('name', 'email', 'phone', 'password', 'minimum', 'delivery', 'image', 'neighborhood_id','state', 'api_token', 'whats_app', 'restaurant_phone', 'pin_code', 'activated');

    public function categories()
    {
        return $this->belongsToMany('App\Model\Category');
    }

    public function scopeAvailable($query)
    {
        $query->where('activated',1)->where('state','open');
    }

    public function neighborhood()
    {
        return $this->belongsTo('App\Model\Neighborhood');
    }

    public function products()
    {
        return $this->hasMany('App\Model\Product');
    }

    public function offers()
    {
        return $this->hasMany('App\Model\Offer');
    }

    public function comments()
    {
        return $this->hasMany('App\Model\Comment');
    }

    public function payments()
    {
        return $this->hasMany('App\Model\Payment');
    }

    public function notifications()
    {
        return $this->morphMany('App\Model\Notification', 'notifiiable');
    }

    public function tokens()
    {
        return $this->morphMany('App\Model\Token', 'tokenable');
    }

    public function orders()
    {
        return $this->hasMany('App\Model\Order');
    }

    public function getTotalOrdersAmountAttribute($value)
    {
        $commissions = $this->orders()->where('state',  'delivered')->sum('total');
        return $commissions;
    }
    public function getTotalCommissionsAttribute($value)
    {
        $commissions = $this->orders()->where('state','delivered')->sum('commission');
        return $commissions;
    }
    public function getTotalPaymentsAttribute($value)
    {
        $payments = $this->payments()->sum('amount');
        return $payments;
    }

    protected $hidden = [
        'password' , 'api_token', 'pin_code'
    ];
}