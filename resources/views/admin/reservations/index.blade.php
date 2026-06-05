@extends('layouts.app')

@section('content')
<div class="luxury-page">
    <div class="max-w-7xl mx-auto py-8 px-4">
        <h1 class="luxury-heading text-3xl mb-6">Manage Reservations</h1>

        @if(session('success'))
            <div class="mb-4 p-4 rounded bg-green-100 text-green-700">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="mb-4 p-4 rounded bg-red-100 text-red-700">
                {{ session('error') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="mb-4 p-4 rounded bg-red-100 text-red-700">
                <ul class="list-disc ml-5">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="luxury-card p-6 overflow-x-auto">
            <table class="w-full border-collapse">
                <thead>
                    <tr style="background-color: #0B1F3A; color: #D4AF37;">
                        <th class="border p-3 text-left">Guest</th>
                        <th class="border p-3 text-left">Room</th>
                        <th class="border p-3 text-left">Check-in</th>
                        <th class="border p-3 text-left">Check-out</th>
                        <th class="border p-3 text-left">Total Price</th>
                        <th class="border p-3 text-left">Reservation Status</th>
                        <th class="border p-3 text-left">Payment Status</th>
                        <th class="border p-3 text-left">Action</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($reservations as $reservation)
                        <tr>
                            <td class="border p-3">
                                {{ $reservation->user->name ?? 'N/A' }}
                            </td>

                            <td class="border p-3">
                                {{ $reservation->room->room_number ?? 'N/A' }}
                                -
                                {{ $reservation->room->room_type ?? 'N/A' }}
                            </td>

                            <td class="border p-3">
                                {{ $reservation->check_in_date }}
                            </td>

                            <td class="border p-3">
                                {{ $reservation->check_out_date }}
                            </td>

                            <td class="border p-3">
                                ₱{{ number_format($reservation->total_price, 2) }}
                            </td>

                            <td class="border p-3">
                                {{ ucfirst($reservation->status) }}

                                @if($reservation->status === 'rejected' && $reservation->rejection_reason)
                                    <div class="mt-2 text-sm text-red-600">
                                        <strong>Reason:</strong> {{ $reservation->rejection_reason }}
                                    </div>
                                @endif
                            </td>

                            <td class="border p-3">
                                {{ $reservation->payment ? ucfirst($reservation->payment->status) : 'No Payment' }}
                            </td>

                            <td class="border p-3">
                                @if($reservation->status === 'pending')
                                    <div class="flex flex-col gap-3">
                                        <form action="{{ route('admin.reservations.approve', $reservation) }}"
                                              method="POST">
                                            @csrf
                                            @method('PATCH')

                                            <button type="submit"
                                                    class="luxury-btn"
                                                    style="border:none; cursor:pointer;"
                                                    onclick="return confirm('Approve this reservation?')">
                                                Approve
                                            </button>
                                        </form>

                                        <form action="{{ route('admin.reservations.reject', $reservation) }}"
                                              method="POST">
                                            @csrf
                                            @method('PATCH')

                                            <textarea name="rejection_reason"
                                                      rows="3"
                                                      class="w-full border p-2 rounded mb-2"
                                                      placeholder="Enter reason for rejection..."
                                                      required></textarea>

                                            <button type="submit"
                                                    class="luxury-btn-navy"
                                                    style="border:none; cursor:pointer;"
                                                    onclick="return confirm('Reject this reservation?')">
                                                Reject
                                            </button>
                                        </form>
                                    </div>
                                @elseif($reservation->status === 'approved')
                                    <span class="text-green-700 font-bold">Approved</span>
                                @elseif($reservation->status === 'rejected')
                                    <span class="text-red-700 font-bold">Rejected</span>
                                @elseif($reservation->status === 'cancelled')
                                    <span class="text-gray-600 font-bold">Cancelled</span>
                                @else
                                    <span>Completed</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="border p-3 text-center">
                                No reservations found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-6">
            <a href="{{ route('admin.dashboard') }}" class="luxury-btn-navy">
                Back to Dashboard
            </a>
        </div>
    </div>
</div>
@endsection