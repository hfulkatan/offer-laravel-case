<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Confirm extends Model
{
    use HasFactory;

    protected $fillable = ['confirm',
        'confirm_description',
        'price',
        'offer_id'];

    protected $hidden = ['created_at', 'updated_at'];


    public function offer() {
        return $this->belongsTo(Offer::class);
    }
}
