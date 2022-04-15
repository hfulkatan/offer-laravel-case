<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Offer extends Model
{
    use HasFactory;

    protected $hidden = ['created_at', 'updated_at', 'product_id', 'product_name'];


    public function getProduct()
    {
        return $this->hasOne('App\Models\Product', 'id', 'product_id');
    }

}
