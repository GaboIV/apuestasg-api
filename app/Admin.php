<?php

namespace App;

use App\Ticket;
use App\Selection;
use App\Transaction;
use App\Events\PlayerCreated;
use App\Events\PlayerUpdated;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Admin extends Model {
    use Notifiable;

    const FEMENINO = 'F';
    const MASCULINO = 'M';

    public static $genders = [self::FEMENINO, self::MASCULINO];

    const SENIOR = 'Sr.';
    const SENIORA = 'Sra.';
    const MISS = 'Srta.';
    const MISTER = 'Srto.';

    public static $treatments = [self::SENIOR, self::SENIORA, self::MISS, self::MISTER];

    protected $fillable = [
        'user_id',
        'document_type',
        'document_number',
        'name',
        'lastname',
        'birthday',
        'gender',
        'city',
        'parish',
        'phone',
        'country_id',
        'state_id',
        'city_id',
        'parish_id',
        'address',
        'browser',
        'timezone',
        'language_id',
        'ip',
        'treatment'
    ];

    public function user() {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function setDoiTypeAttribute($value) {
        $this->attributes['document_number'] = strtoupper($value);
    }
}