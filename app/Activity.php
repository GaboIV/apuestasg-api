<?php

namespace App;

use App\Bank;
use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
	protected $fillable = [
        'user_id',
        'event_type_id',
        'description'
    ];
}
