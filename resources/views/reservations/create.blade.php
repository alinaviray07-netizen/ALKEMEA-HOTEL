@extends('layouts.app')

@section('content')
<div class="luxury-page">
    <div class="max-w-5xl mx-auto py-8 px-4">
        <h1 class="luxury-heading text-3xl mb-6">Reserve Room</h1>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            {{-- Main Reservation Form --}}
            <div class="lg:col-span-2 luxury-card p-6">
                <h2 class="luxury-card-title text-xl mb-4">
                    {{ $room->room_type }} - Room {{ $room->room_number }}
                </h2>

                <p class="mb-2">
                    <strong>Capacity:</strong> {{ $room->capacity }} guest/s
                </p>

                <p class="mb-6">
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
                    <input type="hidden" id="room_price" value="{{ $room->price }}">

                    {{-- Date Selection --}}
                    <div class="mb-6">
                        <h3 class="luxury-card-title text-lg mb-4">Stay Details</h3>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block font-bold mb-2">Check-in Date</label>
                                <input type="date"
                                       name="check_in_date"
                                       id="check_in_date"
                                       value="{{ old('check_in_date') }}"
                                       class="w-full border p-3 rounded"
                                       required>
                            </div>

                            <div>
                                <label class="block font-bold mb-2">Check-out Date</label>
                                <input type="date"
                                       name="check_out_date"
                                       id="check_out_date"
                                       value="{{ old('check_out_date') }}"
                                       class="w-full border p-3 rounded"
                                       required>
                            </div>
                        </div>
                    </div>

                    {{-- Calculation Box --}}
                    <div class="mb-6 p-5 rounded border" style="background:#F8F6F0; border-color:#D4AF37;">
                        <h3 class="font-bold text-lg mb-3">Estimated Payment</h3>

                        <div class="flex justify-between mb-2">
                            <span>Price per night:</span>
                            <strong>₱{{ number_format($room->price, 2) }}</strong>
                        </div>

                        <div class="flex justify-between mb-2">
                            <span>Total nights:</span>
                            <strong id="total_nights">0 night/s</strong>
                        </div>

                        <div class="flex justify-between text-xl mt-4 pt-4 border-t">
                            <span class="font-bold">Total Amount:</span>
                            <strong class="luxury-gold-text" id="total_amount">₱0.00</strong>
                        </div>

                        <p id="date_message" class="text-sm text-red-600 mt-3">
                            Please select valid check-in and check-out dates first.
                        </p>
                    </div>

                    {{-- Payment Section --}}
                    <div id="payment_section" class="opacity-50 pointer-events-none">
                        <h3 class="luxury-card-title text-lg mb-4">Payment Details</h3>

                        <div class="mb-4">
                            <label class="block font-bold mb-2">Select Payment Method</label>
                            <select name="payment_method" id="payment_method" class="w-full border p-3 rounded" required>
                                <option value="">Choose payment method</option>
                                <option value="cash" {{ old('payment_method') === 'cash' ? 'selected' : '' }}>
                                    Cash at Hotel
                                </option>
                                <option value="gcash" {{ old('payment_method') === 'gcash' ? 'selected' : '' }}>
                                    GCash
                                </option>
                                <option value="bank transfer" {{ old('payment_method') === 'bank transfer' ? 'selected' : '' }}>
                                    Bank Transfer
                                </option>
                                <option value="card" {{ old('payment_method') === 'card' ? 'selected' : '' }}>
                                    Credit / Debit Card
                                </option>
                            </select>
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
                                <p class="font-bold mb-1">Hotel GCash Account</p>
                                <p><strong>Account Name:</strong> ALKEMEA Hotel</p>
                                <p><strong>GCash Number:</strong> 0917-000-0000</p>
                                <p class="text-sm text-gray-600 mt-2">
                                    After payment, enter your GCash details and reference number below.
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
                                   placeholder="Enter transaction reference number"
                                   disabled>
                        </div>

                        {{-- Bank Transfer --}}
                        <div id="bank_fields" class="payment-fields hidden mb-6 p-5 rounded border" style="background:#F8F6F0;">
                            <h4 class="font-bold text-lg mb-3">Bank Transfer</h4>

                            <div class="mb-4 p-4 rounded" style="background:white; border:1px dashed #D4AF37;">
                                <p class="font-bold mb-2">Hotel Bank Account</p>
                                <p><strong>Account Name:</strong> ALKEMEA Hotel</p>
                                <p><strong>Account Number:</strong> 0000-1111-2222</p>
                            </div>

                            <label class="block font-bold mb-2">Bank Name</label>
                            <select name="bank_name" class="w-full border p-3 rounded mb-3" disabled>
                                <option value="">Select Bank</option>
                                <option value="BDO" {{ old('bank_name') === 'BDO' ? 'selected' : '' }}>BDO</option>
                                <option value="BPI" {{ old('bank_name') === 'BPI' ? 'selected' : '' }}>BPI</option>
                                <option value="Metrobank" {{ old('bank_name') === 'Metrobank' ? 'selected' : '' }}>Metrobank</option>
                                <option value="Landbank" {{ old('bank_name') === 'Landbank' ? 'selected' : '' }}>Landbank</option>
                                <option value="UnionBank" {{ old('bank_name') === 'UnionBank' ? 'selected' : '' }}>UnionBank</option>
                            </select>

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
                    </div>

                    <button type="submit" id="submit_button" class="btn-luxury opacity-50 pointer-events-none">
                        Submit Reservation
                    </button>

                    <a href="{{ route('home') }}" class="btn-navy ml-2">
                        Cancel
                    </a>
                </form>
            </div>

            {{-- Right Summary --}}
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
                    <span>Total nights</span>
                    <strong id="summary_nights">0</strong>
                </div>

                <div class="flex justify-between mb-2">
                    <span>Capacity</span>
                    <strong>{{ $room->capacity }} guest/s</strong>
                </div>

                <div class="mt-4 p-4 rounded" style="background:#F8F6F0;">
                    <div class="flex justify-between text-lg">
                        <span class="font-bold">Estimated Total:</span>
                        <strong class="luxury-gold-text" id="summary_total">₱0.00</strong>
                    </div>
                </div>

                <div class="mt-4 p-4 rounded border">
                    <p class="font-bold mb-1">Payment Status</p>
                    <p class="text-gray-600">
                        Payment will be recorded as <strong>unpaid</strong> until reviewed by the admin.
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    const checkInInput = document.getElementById('check_in_date');
    const checkOutInput = document.getElementById('check_out_date');
    const roomPrice = parseFloat(document.getElementById('room_price').value);

    const totalNightsText = document.getElementById('total_nights');
    const totalAmountText = document.getElementById('total_amount');
    const summaryNightsText = document.getElementById('summary_nights');
    const summaryTotalText = document.getElementById('summary_total');
    const dateMessage = document.getElementById('date_message');

    const paymentSection = document.getElementById('payment_section');
    const submitButton = document.getElementById('submit_button');
    const paymentSelect = document.getElementById('payment_method');
    const paymentFields = document.querySelectorAll('.payment-fields');

    function pesoFormat(amount) {
        return '₱' + amount.toLocaleString('en-PH', {
            minimumFractionDigits: 2,
            maximumFractionDigits: 2
        });
    }

    function calculateTotal() {
        const checkIn = new Date(checkInInput.value);
        const checkOut = new Date(checkOutInput.value);

        if (!checkInInput.value || !checkOutInput.value || checkOut <= checkIn) {
            totalNightsText.textContent = '0 night/s';
            totalAmountText.textContent = '₱0.00';
            summaryNightsText.textContent = '0';
            summaryTotalText.textContent = '₱0.00';

            dateMessage.textContent = 'Please select valid check-in and check-out dates first.';
            dateMessage.classList.remove('text-green-700');
            dateMessage.classList.add('text-red-600');

            paymentSection.classList.add('opacity-50', 'pointer-events-none');
            submitButton.classList.add('opacity-50', 'pointer-events-none');

            hideAndDisableAllPaymentFields();
            return false;
        }

        const timeDifference = checkOut.getTime() - checkIn.getTime();
        const nights = Math.ceil(timeDifference / (1000 * 60 * 60 * 24));
        const total = nights * roomPrice;

        totalNightsText.textContent = nights + ' night/s';
        totalAmountText.textContent = pesoFormat(total);
        summaryNightsText.textContent = nights;
        summaryTotalText.textContent = pesoFormat(total);

        dateMessage.textContent = 'Total amount calculated. You may now select a payment method.';
        dateMessage.classList.remove('text-red-600');
        dateMessage.classList.add('text-green-700');

        paymentSection.classList.remove('opacity-50', 'pointer-events-none');
        submitButton.classList.remove('opacity-50', 'pointer-events-none');

        return true;
    }

    function hideAndDisableAllPaymentFields() {
        paymentFields.forEach(section => {
            section.classList.add('hidden');

            section.querySelectorAll('input, select, textarea').forEach(input => {
                input.disabled = true;
                input.required = false;
            });
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

        if (!section) return;

        section.classList.remove('hidden');
        enableFields(section);

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

    checkInInput.addEventListener('change', calculateTotal);
    checkOutInput.addEventListener('change', calculateTotal);

    paymentSelect.addEventListener('change', function () {
        showPaymentFields(this.value);
    });

    calculateTotal();

    if (paymentSelect.value) {
        showPaymentFields(paymentSelect.value);
    }
</script>
@endsection