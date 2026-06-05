<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $fillable = [
        'reservation_id',
        'amount',
        'payment_method',
        'payment_account_name',
        'payment_account_number',
        'bank_name',
        'payment_reference',
        'card_last_four',
        'payment_note',
        'status',
        'payment_date',
    ];

    public function reservation()
    {
        return $this->belongsTo(Reservation::class);
    }
}
