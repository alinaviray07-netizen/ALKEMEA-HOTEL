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
                        <th class="border p-3 text-left">Details</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($reservations as $reservation)
                        <tr>
                            <td class="border p-3">{{ $reservation->user->name }}</td>
                            <td class="border p-3">
                                {{ $reservation->room->room_number }} - {{ $reservation->room->room_type }}
                            </td>
                            <td class="border p-3">{{ $reservation->check_in_date }}</td>
                            <td class="border p-3">{{ $reservation->check_out_date }}</td>
                            <td class="border p-3">₱{{ number_format($reservation->total_price, 2) }}</td>
                            <td class="border p-3">{{ ucfirst($reservation->status) }}</td>
                            <td class="border p-3">
                                {{ $reservation->payment ? ucfirst($reservation->payment->status) : 'No Payment' }}
                            </td>
                            <td class="border p-3">
                                @if($reservation->status === 'pending')
                                    <form action="{{ route('admin.reservations.approve', $reservation) }}" method="POST" style="display:inline-block;">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="luxury-btn" style="border:none; cursor:pointer;">
                                            Approve
                                        </button>
                                    </form>

                                    <form action="{{ route('admin.reservations.reject', $reservation) }}" method="POST" style="display:inline-block;">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="luxury-btn-navy" style="border:none; cursor:pointer;">
                                            Reject
                                        </button>
                                    </form>
                                @else
                                    Completed
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