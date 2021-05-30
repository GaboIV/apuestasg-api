<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    public function parishes() {
        return $this->hasMany('App\Parish');
    }
}
