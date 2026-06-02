@extends('layouts.app')

@section('content')
<div class="luxury-page">
    <div class="max-w-7xl mx-auto py-8 px-4">
        <div class="mb-8">
            <h1 class="luxury-heading text-3xl">ALKEMEA Hotel</h1>
            <p class="text-gray-600 mt-2">
                Browse available rooms and choose the best room for your stay.
            </p>
        </div>

        <h2 class="luxury-heading text-2xl mb-6">Available Rooms</h2>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse($rooms as $room)
                <div class="luxury-card overflow-hidden">
                    @if($room->image)
                        <img src="{{ asset('storage/' . $room->image) }}"
                             alt="{{ $room->room_type }}"
                             style="width: 100%; height: 220px; object-fit: cover;">
                    @else
                        <div style="width: 100%; height: 220px; background-color: #e5e0d0; display: flex; align-items: center; justify-content: center; color: #0B1F3A; font-weight: 700;">
                            No Image Available
                        </div>
                    @endif

                    <div class="p-6">
                        <h3 class="luxury-card-title text-xl mb-3">
                            {{ $room->room_type }}
                        </h3>

                        <p class="mb-1">
                            <strong>Room Number:</strong> {{ $room->room_number }}
                        </p>

                        <p class="mb-1">
                            <strong>Capacity:</strong> {{ $room->capacity }} guest/s
                        </p>

                        <p class="mb-1">
                            <strong>Rate:</strong>
                            <span class="luxury-gold-text font-bold">
                                ₱{{ number_format($room->price, 2) }}
                            </span>
                            per night
                        </p>

                        <p class="mb-4">
                            <strong>Status:</strong> {{ ucfirst($room->status) }}
                        </p>

                        <a href="{{ route('rooms.show', $room) }}" class="btn-navy">
                            View Details
                        </a>
                    </div>
                </div>
            @empty
                <div class="luxury-card p-6">
                    <p>No available rooms found.</p>
                </div>
            @endforelse
        </div>
    </div>
</div>
@endsection