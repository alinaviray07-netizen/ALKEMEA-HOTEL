@extends('layouts.app')

@section('content')
<div class="luxury-page">
    <div class="max-w-7xl mx-auto py-8 px-4">
        <h1 class="luxury-heading text-3xl mb-6">Payments</h1>

        @if(session('success'))
            <div class="mb-4 p-4 rounded bg-green-100 text-green-700">
                {{ session('success') }}
            </div>
        @endif

        <div class="luxury-card p-6">
            <div class="table-wrapper">
                <table class="luxury-table">
                    <thead>
                        <tr>
                            <th>Guest Name</th>
                            <th>Room Details</th>
                            <th>Amount</th>
                            <th>Payment Method</th>
                            <th>Payment Status</th>
                            <th>Date Paid</th>
                            <th>Options</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($payments as $payment)
                            <tr>
                                <td>
                                    {{ $payment->reservation->user->name ?? 'N/A' }}
                                </td>

                                <td>
                                    @if($payment->reservation && $payment->reservation->room)
                                        {{ $payment->reservation->room->room_number }}
                                        -
                                        {{ $payment->reservation->room->room_type }}
                                    @else
                                        N/A
                                    @endif
                                </td>

                                <td>
                                    ₱{{ number_format($payment->amount, 2) }}
                                </td>

                                <td>
                                    @if($payment->payment_method === 'cash')
                                        Cash on Arrival
                                    @elseif($payment->payment_method === 'gcash')
                                        GCash
                                    @elseif($payment->payment_method === 'bank transfer')
                                        Bank Transfer
                                    @elseif($payment->payment_method === 'card')
                                        Credit/Debit Card
                                    @else
                                        N/A
                                    @endif
                                </td>

                                <td>
                                    {{ ucfirst($payment->status) }}
                                </td>

                                <td>
                                    {{ $payment->payment_date ?? 'N/A' }}
                                </td>

                                <td>
                                    <div class="table-actions">
                                        <a href="{{ route('admin.payments.show', $payment) }}" class="btn-navy">
                                            Update
                                        </a>

                                        <form action="{{ route('admin.payments.destroy', $payment) }}" method="POST" onsubmit="return confirm('Delete this payment record?')">
                                            @csrf
                                            @method('DELETE')

                                            <button type="submit" class="btn-luxury">
                                                Delete
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center">
                                    No payment records found.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div class="mt-6">
            <a href="{{ route('admin.dashboard') }}" class="btn-navy">
                Back
            </a>
        </div>
    </div>
</div>
@endsection