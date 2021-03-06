<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    public function bills(){
    	return $this->hasMany('App\Bill');
    }

    public function payments(){
    	return $this->hasMany('App\Payment');
    }
}

