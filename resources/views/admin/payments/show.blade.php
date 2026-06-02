@extends('layouts.app')

@section('content')
<div class="luxury-page">
    <div class="max-w-4xl mx-auto py-8 px-4">
        <h1 class="luxury-heading text-3xl mb-6">Payment Details</h1>

        <div class="luxury-card p-6 mb-6">
            <h2 class="luxury-card-title text-2xl mb-4">Reservation Information</h2>

            <p><strong>Guest:</strong> {{ $payment->reservation->user->name ?? 'N/A' }}</p>
            <p><strong>Email:</strong> {{ $payment->reservation->user->email ?? 'N/A' }}</p>

            @if($payment->reservation && $payment->reservation->room)
                <p><strong>Room:</strong> {{ $payment->reservation->room->room_number }} - {{ $payment->reservation->room->room_type }}</p>
            @else
                <p><strong>Room:</strong> N/A</p>
            @endif

            <p><strong>Check-in:</strong> {{ $payment->reservation->check_in_date ?? 'N/A' }}</p>
            <p><strong>Check-out:</strong> {{ $payment->reservation->check_out_date ?? 'N/A' }}</p>
            <p><strong>Reservation Status:</strong> {{ ucfirst($payment->reservation->status ?? 'N/A') }}</p>
            <p>
                <strong>Amount:</strong>
                <span class="luxury-gold-text font-bold">
                    ₱{{ number_format($payment->amount, 2) }}
                </span>
            </p>
        </div>

        <div class="luxury-card p-6">
            <h2 class="luxury-card-title text-2xl mb-4">Update Payment</h2>

            <form action="{{ route('admin.payments.update', $payment) }}" method="POST">
                @csrf
                @method('PATCH')

                <div class="mb-4">
                    <label class="block font-semibold mb-1">Payment Method</label>
                   <select name="payment_method" class="w-full border rounded p-2">
    <option value="cash" {{ $payment->payment_method === 'cash' ? 'selected' : '' }}>Cash on Arrival</option>
    <option value="gcash" {{ $payment->payment_method === 'gcash' ? 'selected' : '' }}>GCash</option>
    <option value="bank transfer" {{ $payment->payment_method === 'bank transfer' ? 'selected' : '' }}>Bank Transfer</option>
    <option value="card" {{ $payment->payment_method === 'card' ? 'selected' : '' }}>Credit/Debit Card</option>
</select>
                    @error('payment_method')
                        <p class="text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-6">
                    <label class="block font-semibold mb-1">Payment Status</label>
                    <select name="status" class="w-full border rounded p-2" required>
                        <option value="unpaid" {{ $payment->status === 'unpaid' ? 'selected' : '' }}>Unpaid</option>
                        <option value="paid" {{ $payment->status === 'paid' ? 'selected' : '' }}>Paid</option>
                        <option value="refunded" {{ $payment->status === 'refunded' ? 'selected' : '' }}>Refunded</option>
                    </select>
                    @error('status')
                        <p class="text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <button type="submit" class="luxury-btn" style="border:none; cursor:pointer;">
                    Update Payment
                </button>

                <a href="{{ route('admin.payments.index') }}" class="luxury-btn-navy">
                    Cancel
                </a>
            </form>
        </div>
    </div>
</div>
@endsection