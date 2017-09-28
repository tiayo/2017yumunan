<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Attribute extends Model
{
    protected $fillable = [
        'name', 'value', 'status', 'category_id'
    ];

    public function category()
    {
        return $this->belongsTo('App\Category');
    }
}
