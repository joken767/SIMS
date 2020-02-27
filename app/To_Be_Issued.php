<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class To_Be_Issued extends Model
{
    protected $table = 'to_be_issued';

    public function stock () {
        return $this->belongsTo ('App\Stock');
    }
}
