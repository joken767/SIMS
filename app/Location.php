<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    protected $table = 'locations';

    public function outgoings () {
    	return $this->hasMany ('App\Issue');
    }
}
