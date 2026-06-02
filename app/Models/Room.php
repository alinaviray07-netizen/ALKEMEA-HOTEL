<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    protected $fillable = [
        'room_number',
        'room_type',
        'price',
        'capacity',
        'description',
        'image',
        'status',
    ];

    public function reservations()
    {
        return $this->hasMany(Reservation::class);
    }
}