<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $table = 'transactions';

    public function stock () {
        return $this->belongsTo ('App\Stock');
    }

    public function incoming () {
        return $this->hasMany ('App\Receive');
    }

    public function outgoing () {
        return $this->hasMany ('App\Issue');
    }
}
