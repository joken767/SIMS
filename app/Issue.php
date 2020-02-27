<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Issue extends Model
{
    protected $table = 'issued';

    public function transactions () {
        return $this->belongsTo ('App\Transaction'); // IF THERE IS A PROBLEM IT IS PROBABLY HERE (?)
    }

    public function location () {
        return $this->belongsTo ('App\Location');
    }

    public function stock () {
        return $this->belongsTo ('App\Stock');
    }

    public function stock_costs () {
        return $this->belongsTo ('App\Stock_Cost');
    }


}
