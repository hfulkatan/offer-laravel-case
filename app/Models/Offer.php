<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Offer extends Model
{
    use HasFactory;

    protected $fillable = [
        "product_id",
        'city',
        'offer_description',
        'email',
    ];

    protected $hidden = ['created_at', 'updated_at', 'product_id'];

    public function product() {
        return $this->belongsTo(Product::class);
    }

}
