@extends('layouts.app')

@section('content')
<div class="luxury-page">
    <div class="max-w-4xl mx-auto py-8 px-4">
        <h1 class="luxury-heading text-3xl mb-6">Reservation Details</h1>

        <div class="luxury-card p-6">
            <h2 class="luxury-card-title text-2xl mb-4">
                {{ $reservation->room->room_type ?? 'Room' }}
                -
                Room {{ $reservation->room->room_number ?? 'N/A' }}
            </h2>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                <p>
                    <strong>Guest:</strong>
                    {{ $reservation->user->name ?? auth()->user()->name }}
                </p>

                <p>
                    <strong>Room Type:</strong>
                    {{ $reservation->room->room_type ?? 'N/A' }}
                </p>

                <p>
                    <strong>Room Number:</strong>
                    {{ $reservation->room->room_number ?? 'N/A' }}
                </p>

                <p>
                    <strong>Capacity:</strong>
                    {{ $reservation->room->capacity ?? 'N/A' }} guest/s
                </p>

                <p>
                    <strong>Check-in Date:</strong>
                    {{ $reservation->check_in_date }}
                </p>

                <p>
                    <strong>Check-out Date:</strong>
                    {{ $reservation->check_out_date }}
                </p>

                <p>
                    <strong>Total Price:</strong>
                    <span class="luxury-gold-text font-bold">
                        ₱{{ number_format($reservation->total_price, 2) }}
                    </span>
                </p>

                <p>
                    <strong>Reservation Status:</strong>
                    {{ ucfirst($reservation->status) }}
                </p>

                <p>
                    <strong>Payment Method:</strong>
                    {{ $reservation->payment ? ucfirst($reservation->payment->payment_method) : 'No Payment' }}
                </p>

                <p>
                    <strong>Payment Status:</strong>
                    {{ $reservation->payment ? ucfirst($reservation->payment->status) : 'No Payment' }}
                </p>
            </div>

            @if($reservation->status === 'rejected' && $reservation->rejection_reason)
                <div class="mt-4 p-4 rounded bg-red-100 text-red-700">
                    <h3 class="font-bold mb-2">Reservation Rejected</h3>
                    <p>
                        <strong>Reason:</strong> {{ $reservation->rejection_reason }}
                    </p>
                </div>
            @endif

            @if($reservation->payment)
                <div class="mt-6 p-4 rounded border" style="background:#F8F6F0;">
                    <h3 class="font-bold mb-3">Payment Details</h3>

                    <p>
                        <strong>Payment Method:</strong>
                        {{ ucfirst($reservation->payment->payment_method) }}
                    </p>

                    @if($reservation->payment->payment_account_name)
                        <p>
                            <strong>Account Name:</strong>
                            {{ $reservation->payment->payment_account_name }}
                        </p>
                    @endif

                    @if($reservation->payment->payment_account_number)
                        <p>
                            <strong>Account Number:</strong>
                            {{ $reservation->payment->payment_account_number }}
                        </p>
                    @endif

                    @if($reservation->payment->bank_name)
                        <p>
                            <strong>Bank Name:</strong>
                            {{ $reservation->payment->bank_name }}
                        </p>
                    @endif

                    @if($reservation->payment->payment_reference)
                        <p>
                            <strong>Reference Number:</strong>
                            {{ $reservation->payment->payment_reference }}
                        </p>
                    @endif

                    @if($reservation->payment->card_last_four)
                        <p>
                            <strong>Card Last 4 Digits:</strong>
                            **** {{ $reservation->payment->card_last_four }}
                        </p>
                    @endif

                    @if($reservation->payment->payment_note)
                        <p>
                            <strong>Note:</strong>
                            {{ $reservation->payment->payment_note }}
                        </p>
                    @endif
                </div>
            @endif

            <div class="mt-6 flex gap-2">
                <a href="{{ route('reservations.index') }}" class="btn-navy">
                    Back to My Reservations
                </a>

                @if($reservation->status === 'pending')
                    <form action="{{ route('reservations.destroy', $reservation) }}"
                          method="POST"
                          onsubmit="return confirm('Cancel this reservation?')">
                        @csrf
                        @method('DELETE')

                        <button type="submit" class="btn-luxury">
                            Cancel Reservation
                        </button>
                    </form>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection