<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_name',
        'is_offerable',
    ];

    protected $hidden = ['created_at', 'updated_at'];

    protected $casts = [
        'is_offerable' => 'bool',
    ];

    public function offers() {
        return $this->hasMany(Offer::class);
    }


}
