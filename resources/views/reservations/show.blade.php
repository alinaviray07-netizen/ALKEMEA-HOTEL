@extends('layouts.app')

@section('content')
<div class="luxury-page">
    <div class="max-w-4xl mx-auto py-8 px-4">
        <h1 class="luxury-heading text-3xl mb-6">Reservation Details</h1>

        <div class="luxury-card p-6">
            <h2 class="luxury-card-title text-2xl mb-4">
                {{ $reservation->room->room_type }}
            </h2>

            <p><strong>Room Number:</strong> {{ $reservation->room->room_number }}</p>
            <p><strong>Check-in Date:</strong> {{ $reservation->check_in_date }}</p>
            <p><strong>Check-out Date:</strong> {{ $reservation->check_out_date }}</p>
            <p>
                <strong>Total Price:</strong>
                <span class="luxury-gold-text font-bold">
                    ₱{{ number_format($reservation->total_price, 2) }}
                </span>
            </p>
            <p><strong>Reservation Status:</strong> {{ ucfirst($reservation->status) }}</p>
            <p>
                <strong>Payment Status:</strong>
                {{ $reservation->payment ? ucfirst($reservation->payment->status) : 'No Payment Record' }}
            </p>
            <p>
                <strong>Payment Method:</strong>
                {{ $reservation->payment ? ucfirst($reservation->payment->payment_method) : 'N/A' }}
            </p>

            <div class="mt-6">
                <a href="{{ route('reservations.index') }}" class="luxury-btn-navy">
                    Back to My Reservations
                </a>
            </div>
        </div>
    </div>
</div>
@endsection