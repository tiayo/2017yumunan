<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'user_id',
        'commodity_id',
        'num',
        'day',
        'price',
        'status',
        'remark'
    ];

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function commodity()
    {
        return $this->belongsTo('App\Commodity');
    }

    public function orderDetail()
    {
        return $this->hasMany('App\OrderDetail');
    }
}
