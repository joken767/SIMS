<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class To_Be_Received extends Model
{
    protected $table = 'to_be_received';

    public function stock () {
        return $this->belongsTo ('App\Stock');
    }
}
