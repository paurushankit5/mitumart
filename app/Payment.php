<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    public function supplier(){
    	return $this->belongsTo('App\Supplier');
    }
}
