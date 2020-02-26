<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{

    protected $fillable = ['category_id', 'name', 'description', 'image', 'price', 'weight', 'status'];
    
    public function category()
    {
        $this->belongsTo('App\Category');
    }
}
