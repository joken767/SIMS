<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Receive extends Model
{
    protected $table = 'received';

    public function transactions () {
        return $this->belongsTo ('App\Transaction');
    }

    public function supplier () {
        return $this->belongsTo ('App\Supplier');
    }

    public function stock () {
        return $this->belongsTo ('App\Stock');
    }

    public function stock_costs () {
        return $this->belongsTo ('App\Stock_Cost');
    }
}
