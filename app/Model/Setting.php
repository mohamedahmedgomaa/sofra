<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model 
{

    protected $table = 'settings';
    public $timestamps = true;
    protected $fillable = array('phone', 'email', 'text', 'contents', 'image', 'whats_app', 'instagram', 'you_tube', 'twitter', 'facebook', 'max_credit', 'commission');

}