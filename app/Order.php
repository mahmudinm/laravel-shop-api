<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = ['user_id', 'district_id', 'invoice', 'user_phone', 'user_address', 'sub_total', 'status'];

    
}
