<?php

namespace App;

use App\Traits\ScopeFilterByColumn;
use Illuminate\Database\Eloquent\Model;
use Staudenmeir\EloquentJsonRelations\HasJsonRelationships;

class MatchStructure extends Model
{
    use ScopeFilterByColumn, HasJsonRelationships;

    protected $fillable = [
        'category_id',
        'principal',
        'main_bet_types'
    ];

    protected $casts = [
        'principal' => 'boolean',
        'main_bet_types' => 'array'
    ];

    public function category() {
        return $this->hasOne(Category::class, 'id', 'category_id');
    }

    public function main_bet_types() {
        return $this->belongsToJson('App\BetType', 'main_bet_types');
    }

    public function searchableColumns(): array
    {
        return [
            'principal',
            'main_bet_types',
            'category_id' => ['condition' => '=']
        ];
    }
}
