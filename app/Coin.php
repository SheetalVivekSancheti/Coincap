<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Coin extends Model
{
    protected $fillable = [
        'name','symbol', 'is_show',
    ];
    public function getRouteKeyName() {
        return 'symbol';
    }
}
