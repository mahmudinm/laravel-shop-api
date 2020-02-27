<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $fillable = ['order_id', 'name', 'transfer_to', 'transfer_date', 'amount'];
}
