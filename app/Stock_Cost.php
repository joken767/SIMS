<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Stock_Cost extends Model
{
    protected $table = 'stock_costs';

    public function stock () {
        return $this->belongsTo ('App\Stock');
    }

    public function issue () {
        return $this->hasMany ('App\Issue');
    }

    public function receive () {
        return $this->hasMany ('App\Receive');
    }
}
