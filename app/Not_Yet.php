<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Not_Yet extends Model
{
    protected $table = 'not_yet_to_be_issued';

    public function stock () {
        return $this->belongsTo ('App\Stock');
    }
}
