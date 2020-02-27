<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = ['user_id', 'district_id', 'invoice', 'user_phone', 'user_address', 'sub_total', 'status'];

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function district()
    {
        return $this->belongsTo('App\District');
    }
    
    public function details()
    {
        return $this->hasMany('App\OrderDetails');
    }

}
