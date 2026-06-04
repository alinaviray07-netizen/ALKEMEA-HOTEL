@extends('layouts.app')

@section('content')
<div class="luxury-page">
    <div class="max-w-7xl mx-auto py-10 px-4 sm:px-6 lg:px-8">
        <div class="mb-10">
            <h1 class="luxury-heading text-3xl mb-3">ALKEMEA Hotel</h1>
            <p class="text-gray-600">
                Browse available room types and choose your preferred room number.
            </p>
        </div>

        <h2 class="luxury-heading text-2xl mb-8">Available Rooms</h2>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse($availableRoomTypes as $roomType => $rooms)
                @php
                    $sampleRoom = $rooms->first();
                @endphp

                <div class="luxury-card overflow-hidden">
                    @if($sampleRoom->image)
                        <img src="{{ asset('storage/' . $sampleRoom->image) }}"
                             alt="{{ $roomType }}"
                             class="room-image">
                    @else
                        <div class="no-image-box">
                            No Image Available
                        </div>
                    @endif

                    <div class="p-6">
                        <h3 class="luxury-card-title text-xl mb-4">
                            {{ $roomType }}
                        </h3>

                        <p class="mb-2">
                            <strong>Available Rooms:</strong>
                            <span class="luxury-gold-text font-bold">
                                {{ $rooms->count() }}
                            </span>
                        </p>

                        <p class="mb-2">
                            <strong>Capacity:</strong> {{ $sampleRoom->capacity }} guest/s
                        </p>

                        <p class="mb-2">
                            <strong>Rate:</strong>
                            <span class="luxury-gold-text font-bold">
                                ₱{{ number_format($sampleRoom->price, 2) }}
                            </span>
                            per night
                        </p>

                        <p class="mb-3">
                            <strong>Room Numbers:</strong>
                        </p>

                        <div class="flex flex-wrap gap-2 mb-5">
                            @foreach($rooms as $room)
                                <span class="inline-block px-3 py-1 rounded text-sm font-bold"
                                      style="background-color: #F8F6F0; color: #0B1F3A; border: 1px solid #D4AF37;">
                                    {{ $room->room_number }}
                                </span>
                            @endforeach
                        </div>

                        <a href="{{ route('rooms.type.show', $roomType) }}" class="btn-navy">
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