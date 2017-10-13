<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    protected $fillable = [
        'num', 'commodity_id', 'status'
    ];

    public function commodity()
    {
        return $this->belongsTo('App\Commodity');
    }
}
