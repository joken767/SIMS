<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Stock extends Model
{
    protected $table = 'stocks';

    public function stock_costs () {
        return $this->hasMany ('App\Stock_Cost');
    }

    public function transactions () {
        return $this->hasMany ('App\Transaction');
    }

    public function to_be_issued () {
        return $this->hasMany ('App\To_Be_Issued');
    }

    public function not_yet () {
        return $this->hasMany ('App\Not_Yet');
    }

    public function to_be_received () {
        return $this->hasMany ('App\To_Be_Received');
    }

    public function issue () {
        return $this->hasMany ('App\Issue');
    }

    public function receive () {
        return $this->hasMany ('App\Receive');
    }
}
