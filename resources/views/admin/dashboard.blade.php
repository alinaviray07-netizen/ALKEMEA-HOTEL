@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto py-6 px-4">
    <h1 class="text-2xl font-bold mb-6">Admin Dashboard</h1>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <div class="bg-white border rounded-lg shadow-sm p-6">
            <h3 class="text-lg font-semibold text-gray-700">Total Rooms</h3>
            <p class="text-3xl font-bold mt-2">{{ $totalRooms }}</p>
        </div>

        <div class="bg-white border rounded-lg shadow-sm p-6">
            <h3 class="text-lg font-semibold text-gray-700">Available Rooms</h3>
            <p class="text-3xl font-bold mt-2">{{ $availableRooms }}</p>
        </div>

        <div class="bg-white border rounded-lg shadow-sm p-6">
            <h3 class="text-lg font-semibold text-gray-700">Total Reservations</h3>
            <p class="text-3xl font-bold mt-2">{{ $totalReservations }}</p>
        </div>

        <div class="bg-white border rounded-lg shadow-sm p-6">
            <h3 class="text-lg font-semibold text-gray-700">Pending Reservations</h3>
            <p class="text-3xl font-bold mt-2">{{ $pendingReservations }}</p>
        </div>

        <div class="bg-white border rounded-lg shadow-sm p-6">
            <h3 class="text-lg font-semibold text-gray-700">Total Payments</h3>
            <p class="text-3xl font-bold mt-2">{{ $totalPayments }}</p>
        </div>

        <div class="bg-white border rounded-lg shadow-sm p-6">
            <h3 class="text-lg font-semibold text-gray-700">Total Guests</h3>
            <p class="text-3xl font-bold mt-2">{{ $totalUsers }}</p>
        </div>
    </div>

<div class="flex flex-wrap gap-2">
    <a href="{{ route('admin.rooms.index') }}" class="btn-luxury">
        Manage Rooms
    </a>

    <a href="{{ route('admin.reservations.index') }}" class="btn-navy">
        Manage Reservations
    </a>

    <a href="{{ route('admin.payments.index') }}" class="btn-navy">
        Manage Payments
    </a>


</div>
</div>
@endsection