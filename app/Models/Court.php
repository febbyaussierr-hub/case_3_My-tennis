<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Court extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'seller_id',
        'name',
        'venue_name',
        'city',
        'province',
        'address',
        'price_per_hour',
        'image',
        'description',
        'status',
    ];

    public function seller()
    {
        return $this->belongsTo(User::class, 'seller_id');
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }
}