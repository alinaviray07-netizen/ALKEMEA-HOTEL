@extends('layouts.app')

@section('content')
<div class="luxury-page">
    <div class="max-w-4xl mx-auto py-8 px-4">
        <h1 class="luxury-heading text-3xl mb-6">Reserve Room</h1>

        @if(session('error'))
            <div class="mb-4 p-4 rounded bg-red-100 text-red-700">
                {{ session('error') }}
            </div>
        @endif

        <div class="luxury-card p-6 mb-6">
            <h2 class="luxury-card-title text-2xl mb-3">{{ $room->room_type }}</h2>

            @if($room->image)
                <img src="{{ asset('storage/' . $room->image) }}"
                     alt="{{ $room->room_type }}"
                     style="width: 100%; height: 260px; object-fit: cover; border-radius: 12px; margin-bottom: 18px;">
            @endif

            <p><strong>Room Number:</strong> {{ $room->room_number }}</p>
            <p><strong>Capacity:</strong> {{ $room->capacity }} guest/s</p>
            <p>
                <strong>Rate:</strong>
                <span class="luxury-gold-text font-bold">
                    ₱{{ number_format($room->price, 2) }}
                </span>
                per night
            </p>
            <p><strong>Status:</strong> {{ ucfirst($room->status) }}</p>
            <p><strong>Description:</strong> {{ $room->description ?? 'No description available.' }}</p>
        </div>

        <div class="luxury-card p-6">
            <form action="{{ route('reservations.store') }}" method="POST">
                @csrf

                <input type="hidden" name="room_id" value="{{ $room->id }}">

                <div class="mb-4">
                    <label class="block font-semibold mb-1">Check-in Date</label>
                    <input type="date" name="check_in_date" value="{{ old('check_in_date') }}" class="w-full border rounded p-2" required>

                    @error('check_in_date')
                        <p class="text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label class="block font-semibold mb-1">Check-out Date</label>
                    <input type="date" name="check_out_date" value="{{ old('check_out_date') }}" class="w-full border rounded p-2" required>

                    @error('check_out_date')
                        <p class="text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label class="block font-semibold mb-1">Payment Method</label>
                    <select name="payment_method" class="w-full border rounded p-2" required>
                        <option value="">Select payment method</option>
                        <option value="cash" {{ old('payment_method') === 'cash' ? 'selected' : '' }}>Cash on Arrival</option>
                        <option value="gcash" {{ old('payment_method') === 'gcash' ? 'selected' : '' }}>GCash</option>
                        <option value="bank transfer" {{ old('payment_method') === 'bank transfer' ? 'selected' : '' }}>Bank Transfer</option>
                        <option value="card" {{ old('payment_method') === 'card' ? 'selected' : '' }}>Credit/Debit Card</option>
                    </select>

                    @error('payment_method')
                        <p class="text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-6 p-4 rounded" style="background-color: #F8F6F0;">
                    <p class="text-sm text-gray-700">
                        The total amount will be computed automatically based on the number of nights. Payment status will remain unpaid until confirmed by the admin.
                    </p>
                </div>

                <button type="submit" class="btn-luxury">
                    Submit
                </button>

                <a href="{{ route('rooms.show', $room) }}" class="btn-navy">
                    Cancel
                </a>
            </form>
        </div>
    </div>
</div>
@endsection