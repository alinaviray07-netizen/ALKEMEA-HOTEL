@extends('layouts.app')

@section('content')
<div class="luxury-page">
    <div class="max-w-7xl mx-auto py-8 px-4">
        <div class="flex justify-between items-center mb-6">
            <h1 class="luxury-heading text-3xl">Reservation Reports</h1>

            <a href="{{ route('admin.dashboard') }}" class="luxury-btn-navy">
                Back to Dashboard
            </a>
        </div>

        {{-- Report Summary Cards --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <div class="luxury-card p-6">
                <h3 class="luxury-card-title text-lg">Total Reservations</h3>
                <p class="text-4xl font-bold luxury-gold-text mt-2">{{ $totalReservations }}</p>
            </div>

            <div class="luxury-card p-6">
                <h3 class="luxury-card-title text-lg">Approved Reservations</h3>
                <p class="text-4xl font-bold luxury-gold-text mt-2">{{ $approvedReservations }}</p>
            </div>

            <div class="luxury-card p-6">
                <h3 class="luxury-card-title text-lg">Pending Reservations</h3>
                <p class="text-4xl font-bold luxury-gold-text mt-2">{{ $pendingReservations }}</p>
            </div>

            <div class="luxury-card p-6">
                <h3 class="luxury-card-title text-lg">Rejected Reservations</h3>
                <p class="text-4xl font-bold luxury-gold-text mt-2">{{ $rejectedReservations }}</p>
            </div>

            <div class="luxury-card p-6">
                <h3 class="luxury-card-title text-lg">Cancelled Reservations</h3>
                <p class="text-4xl font-bold luxury-gold-text mt-2">{{ $cancelledReservations }}</p>
            </div>

            <div class="luxury-card p-6">
                <h3 class="luxury-card-title text-lg">Total Revenue</h3>
                <p class="text-4xl font-bold luxury-gold-text mt-2">
                    ₱{{ number_format($totalRevenue, 2) }}
                </p>
            </div>
        </div>

        {{-- Export Reports --}}
        <div class="luxury-card p-6 mb-8">
            <h2 class="luxury-card-title text-2xl mb-4">Export Reports</h2>

            <div class="mb-6">
                <h3 class="font-bold mb-2">Reservation Reports</h3>

                <div class="flex flex-wrap gap-2">
                    <a href="{{ route('admin.reports.export', ['reservations', 'csv']) }}" class="luxury-btn-navy">
                        CSV
                    </a>

                    <a href="{{ route('admin.reports.export', ['reservations', 'json']) }}" class="luxury-btn-navy">
                        JSON
                    </a>

                    <a href="{{ route('admin.reports.export', ['reservations', 'xlsx']) }}" class="luxury-btn-navy">
                        XLSX
                    </a>

                    <a href="{{ route('admin.reports.export', ['reservations', 'pdf']) }}" class="luxury-btn">
                        PDF
                    </a>
                </div>
            </div>

            <div class="mb-6">
                <h3 class="font-bold mb-2">Payment Reports</h3>

                <div class="flex flex-wrap gap-2">
                    <a href="{{ route('admin.reports.export', ['payments', 'csv']) }}" class="luxury-btn-navy">
                        CSV
                    </a>

                    <a href="{{ route('admin.reports.export', ['payments', 'json']) }}" class="luxury-btn-navy">
                        JSON
                    </a>

                    <a href="{{ route('admin.reports.export', ['payments', 'xlsx']) }}" class="luxury-btn-navy">
                        XLSX
                    </a>

                    <a href="{{ route('admin.reports.export', ['payments', 'pdf']) }}" class="luxury-btn">
                        PDF
                    </a>
                </div>
            </div>

            <div>
                <h3 class="font-bold mb-2">Room Availability Reports</h3>

                <div class="flex flex-wrap gap-2">
                    <a href="{{ route('admin.reports.export', ['rooms', 'csv']) }}" class="luxury-btn-navy">
                        CSV
                    </a>

                    <a href="{{ route('admin.reports.export', ['rooms', 'json']) }}" class="luxury-btn-navy">
                        JSON
                    </a>

                    <a href="{{ route('admin.reports.export', ['rooms', 'xlsx']) }}" class="luxury-btn-navy">
                        XLSX
                    </a>

                    <a href="{{ route('admin.reports.export', ['rooms', 'pdf']) }}" class="luxury-btn">
                        PDF
                    </a>
                </div>
            </div>
        </div>

        {{-- Reservation Report List --}}
        <div class="luxury-card p-6 overflow-x-auto">
            <h2 class="luxury-card-title text-2xl mb-4">Reservation Report List</h2>

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
                        <th class="border p-3 text-left">Rejection Reason</th>
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
                            </td>

                            <td class="border p-3">
                                {{ $reservation->payment ? ucfirst($reservation->payment->status) : 'No Payment' }}
                            </td>

                            <td class="border p-3">
                                @if($reservation->status === 'rejected' && $reservation->rejection_reason)
                                    {{ $reservation->rejection_reason }}
                                @else
                                    N/A
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="border p-3 text-center">
                                No reservation reports found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection