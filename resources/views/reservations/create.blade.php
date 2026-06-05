@extends('layouts.app')

@section('content')
<div class="luxury-page">
    <div class="max-w-4xl mx-auto py-8 px-4">
        <h1 class="luxury-heading text-3xl mb-6">Reserve Room</h1>

        <div class="luxury-card p-6">
            <h2 class="luxury-card-title text-xl mb-4">
                {{ $room->room_type }} - Room {{ $room->room_number }}
            </h2>

            <p class="mb-2"><strong>Capacity:</strong> {{ $room->capacity }} guest/s</p>
            <p class="mb-4">
                <strong>Rate:</strong>
                <span class="luxury-gold-text font-bold">
                    ₱{{ number_format($room->price, 2) }}
                </span>
                per night
            </p>

            @if ($errors->any())
                <div class="mb-4 p-4 rounded bg-red-100 text-red-700">
                    <ul class="list-disc ml-5">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('reservations.store') }}">
                @csrf

                <input type="hidden" name="room_id" value="{{ $room->id }}">

                <div class="mb-4">
                    <label class="block font-bold mb-2">Check-in Date</label>
                    <input type="date"
                           name="check_in_date"
                           value="{{ old('check_in_date') }}"
                           class="w-full border p-3 rounded"
                           required>
                </div>

                <div class="mb-4">
                    <label class="block font-bold mb-2">Check-out Date</label>
                    <input type="date"
                           name="check_out_date"
                           value="{{ old('check_out_date') }}"
                           class="w-full border p-3 rounded"
                           required>
                </div>

                <div class="mb-4">
                    <label class="block font-bold mb-2">Payment Method</label>
                    <select name="payment_method" id="payment_method" class="w-full border p-3 rounded" required>
                        <option value="">Select Payment Method</option>
                        <option value="cash" {{ old('payment_method') === 'cash' ? 'selected' : '' }}>Cash</option>
                        <option value="gcash" {{ old('payment_method') === 'gcash' ? 'selected' : '' }}>GCash</option>
                        <option value="bank transfer" {{ old('payment_method') === 'bank transfer' ? 'selected' : '' }}>Bank Transfer</option>
                        <option value="card" {{ old('payment_method') === 'card' ? 'selected' : '' }}>Card</option>
                    </select>
                </div>

                {{-- Cash --}}
                <div id="cash_fields" class="payment-fields hidden mb-4 p-4 rounded" style="background:#F8F6F0;">
                    <p class="font-bold">Cash Payment</p>
                    <p class="text-gray-600">Payment will be settled at the hotel front desk.</p>

                    <input type="hidden"
                           name="payment_note"
                           value="Payment will be settled at the hotel front desk."
                           disabled>
                </div>

                {{-- GCash --}}
                <div id="gcash_fields" class="payment-fields hidden mb-4 p-4 rounded" style="background:#F8F6F0;">
                    <h3 class="font-bold mb-3">GCash Details</h3>

                    <label class="block font-bold mb-2">GCash Account Name</label>
                    <input type="text"
                           name="payment_account_name"
                           value="{{ old('payment_account_name') }}"
                           class="w-full border p-3 rounded mb-3"
                           disabled>

                    <label class="block font-bold mb-2">GCash Number</label>
                    <input type="text"
                           name="payment_account_number"
                           value="{{ old('payment_account_number') }}"
                           class="w-full border p-3 rounded mb-3"
                           disabled>

                    <label class="block font-bold mb-2">Reference Number</label>
                    <input type="text"
                           name="payment_reference"
                           value="{{ old('payment_reference') }}"
                           class="w-full border p-3 rounded"
                           disabled>
                </div>

                {{-- Bank Transfer --}}
                <div id="bank_fields" class="payment-fields hidden mb-4 p-4 rounded" style="background:#F8F6F0;">
                    <h3 class="font-bold mb-3">Bank Transfer Details</h3>

                    <label class="block font-bold mb-2">Bank Name</label>
                    <input type="text"
                           name="bank_name"
                           value="{{ old('bank_name') }}"
                           class="w-full border p-3 rounded mb-3"
                           disabled>

                    <label class="block font-bold mb-2">Account Name</label>
                    <input type="text"
                           name="payment_account_name"
                           value="{{ old('payment_account_name') }}"
                           class="w-full border p-3 rounded mb-3"
                           disabled>

                    <label class="block font-bold mb-2">Account Number</label>
                    <input type="text"
                           name="payment_account_number"
                           value="{{ old('payment_account_number') }}"
                           class="w-full border p-3 rounded mb-3"
                           disabled>

                    <label class="block font-bold mb-2">Reference Number</label>
                    <input type="text"
                           name="payment_reference"
                           value="{{ old('payment_reference') }}"
                           class="w-full border p-3 rounded"
                           disabled>
                </div>

                {{-- Card --}}
                <div id="card_fields" class="payment-fields hidden mb-4 p-4 rounded" style="background:#F8F6F0;">
                    <h3 class="font-bold mb-3">Card Payment Details</h3>

                    <label class="block font-bold mb-2">Cardholder Name</label>
                    <input type="text"
                           name="payment_account_name"
                           value="{{ old('payment_account_name') }}"
                           class="w-full border p-3 rounded mb-3"
                           disabled>

                    <label class="block font-bold mb-2">Last 4 Digits of Card</label>
                    <input type="text"
                           name="card_last_four"
                           value="{{ old('card_last_four') }}"
                           maxlength="4"
                           class="w-full border p-3 rounded mb-3"
                           disabled>

                    <p class="text-sm text-gray-600">
                        For demo purposes, the system only stores the last 4 digits and does not process real card payments.
                    </p>
                </div>

                <button type="submit" class="btn-luxury">
                    Submit Reservation
                </button>

                <a href="{{ route('home') }}" class="btn-navy ml-2">
                    Cancel
                </a>
            </form>
        </div>
    </div>
</div>

<script>
    const paymentSelect = document.getElementById('payment_method');
    const paymentFields = document.querySelectorAll('.payment-fields');

    function hideAndDisableAllPaymentFields() {
        paymentFields.forEach(section => {
            section.classList.add('hidden');

            section.querySelectorAll('input, select, textarea').forEach(input => {
                input.disabled = true;
                input.required = false;
            });
        });
    }

    function showAndEnablePaymentFields(method) {
        hideAndDisableAllPaymentFields();

        let section = null;

        if (method === 'cash') {
            section = document.getElementById('cash_fields');
        }

        if (method === 'gcash') {
            section = document.getElementById('gcash_fields');
        }

        if (method === 'bank transfer') {
            section = document.getElementById('bank_fields');
        }

        if (method === 'card') {
            section = document.getElementById('card_fields');
        }

        if (section) {
            section.classList.remove('hidden');

            section.querySelectorAll('input, select, textarea').forEach(input => {
                input.disabled = false;
            });

            if (method === 'gcash') {
                section.querySelector('[name="payment_account_name"]').required = true;
                section.querySelector('[name="payment_account_number"]').required = true;
                section.querySelector('[name="payment_reference"]').required = true;
            }

            if (method === 'bank transfer') {
                section.querySelector('[name="bank_name"]').required = true;
                section.querySelector('[name="payment_account_name"]').required = true;
                section.querySelector('[name="payment_account_number"]').required = true;
                section.querySelector('[name="payment_reference"]').required = true;
            }

            if (method === 'card') {
                section.querySelector('[name="payment_account_name"]').required = true;
                section.querySelector('[name="card_last_four"]').required = true;
            }
        }
    }

    paymentSelect.addEventListener('change', function () {
        showAndEnablePaymentFields(this.value);
    });

    showAndEnablePaymentFields(paymentSelect.value);
</script>
@endsection