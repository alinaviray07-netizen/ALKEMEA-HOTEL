@extends('layouts.app')

@section('content')
<div class="luxury-page">
    <div class="max-w-5xl mx-auto py-8 px-4">
        <h1 class="luxury-heading text-3xl mb-6">Reserve Room</h1>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            {{-- LEFT SIDE: Reservation Form --}}
            <div class="lg:col-span-2 luxury-card p-6">
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

                    <div class="mb-6">
                        <label class="block font-bold mb-2">Check-out Date</label>
                        <input type="date"
                               name="check_out_date"
                               value="{{ old('check_out_date') }}"
                               class="w-full border p-3 rounded"
                               required>
                    </div>

                    <h3 class="luxury-card-title text-xl mb-4">Payment Method</h3>

                    {{-- Payment Method Cards --}}
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                        <label class="payment-option border rounded p-4 cursor-pointer">
                            <input type="radio" name="payment_method" value="gcash" class="payment-radio mr-2"
                                {{ old('payment_method') === 'gcash' ? 'checked' : '' }}>
                            <span class="font-bold">GCash</span>
                            <p class="text-sm text-gray-600 mt-1">Pay using your GCash account and reference number.</p>
                        </label>

                        <label class="payment-option border rounded p-4 cursor-pointer">
                            <input type="radio" name="payment_method" value="bank transfer" class="payment-radio mr-2"
                                {{ old('payment_method') === 'bank transfer' ? 'checked' : '' }}>
                            <span class="font-bold">Bank Transfer</span>
                            <p class="text-sm text-gray-600 mt-1">Transfer payment through your selected bank.</p>
                        </label>

                        <label class="payment-option border rounded p-4 cursor-pointer">
                            <input type="radio" name="payment_method" value="card" class="payment-radio mr-2"
                                {{ old('payment_method') === 'card' ? 'checked' : '' }}>
                            <span class="font-bold">Credit / Debit Card</span>
                            <p class="text-sm text-gray-600 mt-1">For demo, only last 4 digits are stored.</p>
                        </label>

                        <label class="payment-option border rounded p-4 cursor-pointer">
                            <input type="radio" name="payment_method" value="cash" class="payment-radio mr-2"
                                {{ old('payment_method') === 'cash' ? 'checked' : '' }}>
                            <span class="font-bold">Cash at Hotel</span>
                            <p class="text-sm text-gray-600 mt-1">Pay directly at the hotel front desk.</p>
                        </label>
                    </div>

                    {{-- Cash --}}
                    <div id="cash_fields" class="payment-fields hidden mb-6 p-5 rounded border" style="background:#F8F6F0;">
                        <h4 class="font-bold text-lg mb-2">Cash at Hotel</h4>
                        <p class="text-gray-700">
                            Your reservation will be submitted first. Payment will be settled at the hotel front desk.
                        </p>

                        <input type="hidden"
                               name="payment_note"
                               value="Payment will be settled at the hotel front desk."
                               disabled>
                    </div>

                    {{-- GCash --}}
                    <div id="gcash_fields" class="payment-fields hidden mb-6 p-5 rounded border" style="background:#F8F6F0;">
                        <h4 class="font-bold text-lg mb-3">GCash Payment</h4>

                        <div class="mb-4 p-4 rounded" style="background:white; border:1px dashed #D4AF37;">
                            <p class="font-bold mb-1">Send payment to:</p>
                            <p><strong>GCash Name:</strong> ALKEMEA Hotel</p>
                            <p><strong>GCash Number:</strong> 0917-000-0000</p>
                            <p class="text-sm text-gray-600 mt-2">
                                After sending payment, enter your GCash account details and reference number below.
                            </p>
                        </div>

                        <label class="block font-bold mb-2">Your GCash Account Name</label>
                        <input type="text"
                               name="payment_account_name"
                               value="{{ old('payment_account_name') }}"
                               class="w-full border p-3 rounded mb-3"
                               disabled>

                        <label class="block font-bold mb-2">Your GCash Number</label>
                        <input type="text"
                               name="payment_account_number"
                               value="{{ old('payment_account_number') }}"
                               class="w-full border p-3 rounded mb-3"
                               placeholder="09XXXXXXXXX"
                               disabled>

                        <label class="block font-bold mb-2">GCash Reference Number</label>
                        <input type="text"
                               name="payment_reference"
                               value="{{ old('payment_reference') }}"
                               class="w-full border p-3 rounded"
                               placeholder="Example: 1234567890123"
                               disabled>
                    </div>

                    {{-- Bank Transfer --}}
                    <div id="bank_fields" class="payment-fields hidden mb-6 p-5 rounded border" style="background:#F8F6F0;">
                        <h4 class="font-bold text-lg mb-3">Bank Transfer</h4>

                        <div class="mb-4 p-4 rounded" style="background:white; border:1px dashed #D4AF37;">
                            <p class="font-bold mb-2">Select bank and transfer payment to ALKEMEA Hotel account.</p>

                            <label class="block font-bold mb-2">Bank Name</label>
                            <select name="bank_name" class="w-full border p-3 rounded mb-3" disabled>
                                <option value="">Select Bank</option>
                                <option value="BDO" {{ old('bank_name') === 'BDO' ? 'selected' : '' }}>BDO</option>
                                <option value="BPI" {{ old('bank_name') === 'BPI' ? 'selected' : '' }}>BPI</option>
                                <option value="Metrobank" {{ old('bank_name') === 'Metrobank' ? 'selected' : '' }}>Metrobank</option>
                                <option value="Landbank" {{ old('bank_name') === 'Landbank' ? 'selected' : '' }}>Landbank</option>
                                <option value="UnionBank" {{ old('bank_name') === 'UnionBank' ? 'selected' : '' }}>UnionBank</option>
                            </select>

                            <p><strong>Hotel Account Name:</strong> ALKEMEA Hotel</p>
                            <p><strong>Hotel Account Number:</strong> 0000-1111-2222</p>
                        </div>

                        <label class="block font-bold mb-2">Your Account Name</label>
                        <input type="text"
                               name="payment_account_name"
                               value="{{ old('payment_account_name') }}"
                               class="w-full border p-3 rounded mb-3"
                               disabled>

                        <label class="block font-bold mb-2">Your Account Number</label>
                        <input type="text"
                               name="payment_account_number"
                               value="{{ old('payment_account_number') }}"
                               class="w-full border p-3 rounded mb-3"
                               disabled>

                        <label class="block font-bold mb-2">Bank Transfer Reference Number</label>
                        <input type="text"
                               name="payment_reference"
                               value="{{ old('payment_reference') }}"
                               class="w-full border p-3 rounded"
                               disabled>
                    </div>

                    {{-- Card --}}
                    <div id="card_fields" class="payment-fields hidden mb-6 p-5 rounded border" style="background:#F8F6F0;">
                        <h4 class="font-bold text-lg mb-3">Credit / Debit Card</h4>

                        <div class="mb-4 p-4 rounded bg-yellow-50 text-yellow-800">
                            This is a demo payment form only. The system does not process real card payments and does not store full card numbers.
                        </div>

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
                               placeholder="1234"
                               disabled>

                        <label class="block font-bold mb-2">Payment Reference / Approval Code</label>
                        <input type="text"
                               name="payment_reference"
                               value="{{ old('payment_reference') }}"
                               class="w-full border p-3 rounded"
                               placeholder="Optional demo reference"
                               disabled>
                    </div>

                    <button type="submit" class="btn-luxury">
                        Place Reservation
                    </button>

                    <a href="{{ route('home') }}" class="btn-navy ml-2">
                        Cancel
                    </a>
                </form>
            </div>

            {{-- RIGHT SIDE: Order Summary --}}
            <div class="luxury-card p-6 h-fit">
                <h3 class="luxury-card-title text-xl mb-4">Reservation Summary</h3>

                <div class="border-b pb-3 mb-3">
                    <p class="font-bold">{{ $room->room_type }}</p>
                    <p class="text-gray-600">Room {{ $room->room_number }}</p>
                </div>

                <div class="flex justify-between mb-2">
                    <span>Price per night</span>
                    <strong>₱{{ number_format($room->price, 2) }}</strong>
                </div>

                <div class="flex justify-between mb-2">
                    <span>Capacity</span>
                    <strong>{{ $room->capacity }} guest/s</strong>
                </div>

                <div class="mt-4 p-4 rounded" style="background:#F8F6F0;">
                    <p class="text-sm text-gray-700">
                        Your total price will be calculated based on your check-in and check-out dates after submitting the reservation.
                    </p>
                </div>

                <div class="mt-4 p-4 rounded border">
                    <p class="font-bold mb-1">Payment Status</p>
                    <p class="text-gray-600">
                        Payment will be recorded as <strong>unpaid</strong> until reviewed or approved by the admin.
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .payment-option {
        background: white;
        transition: 0.2s ease;
    }

    .payment-option:hover {
        border-color: #D4AF37;
        box-shadow: 0 4px 12px rgba(11, 31, 58, 0.08);
    }

    .payment-option.active {
        border: 2px solid #D4AF37;
        background: #FFFBEA;
    }
</style>

<script>
    const paymentRadios = document.querySelectorAll('.payment-radio');
    const paymentFields = document.querySelectorAll('.payment-fields');
    const paymentOptions = document.querySelectorAll('.payment-option');

    function hideAndDisableAllPaymentFields() {
        paymentFields.forEach(section => {
            section.classList.add('hidden');

            section.querySelectorAll('input, select, textarea').forEach(input => {
                input.disabled = true;
                input.required = false;
            });
        });

        paymentOptions.forEach(option => {
            option.classList.remove('active');
        });
    }

    function enableFields(section) {
        section.querySelectorAll('input, select, textarea').forEach(input => {
            input.disabled = false;
        });
    }

    function showPaymentFields(method) {
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

        if (! section) return;

        section.classList.remove('hidden');
        enableFields(section);

        document.querySelector(`input[value="${method}"]`)?.closest('.payment-option')?.classList.add('active');

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

    paymentRadios.forEach(radio => {
        radio.addEventListener('change', function () {
            showPaymentFields(this.value);
        });

        if (radio.checked) {
            showPaymentFields(radio.value);
        }
    });
</script>
@endsection