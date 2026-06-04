@extends('layouts.app')

@section('content')
<div class="luxury-page">
    <div class="max-w-7xl mx-auto py-10 px-4 sm:px-6 lg:px-8">
        <div class="mb-10">
            <h1 class="luxury-heading text-3xl mb-3">ALKEMEA Hotel</h1>
            <p class="text-gray-600">
                Browse available rooms, choose a specific room, and reserve your stay.
            </p>
        </div>

        {{-- Room Availability Summary --}}
        <div class="mb-10">
            <h2 class="luxury-heading text-2xl mb-6">Room Availability</h2>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @forelse($availableRoomGroups as $roomType => $groupedRooms)
                    <div class="luxury-card p-6">
                        <h3 class="luxury-card-title text-xl mb-2">
                            {{ $roomType }}
                        </h3>

                        <p class="mb-4">
                            <span class="luxury-gold-text font-bold text-2xl">
                                {{ $groupedRooms->count() }}
                            </span>
                            available room/s
                        </p>

                        <p class="font-semibold mb-2">Available Room Numbers:</p>

                        <div class="flex flex-wrap gap-2">
                            @foreach($groupedRooms as $availableRoom)
                                <a href="{{ route('rooms.show', $availableRoom) }}"
                                   class="btn-navy"
                                   style="padding: 7px 12px; font-size: 14px;">
                                    Room {{ $availableRoom->room_number }}
                                </a>
                            @endforeach
                        </div>
                    </div>
                @empty
                    <div class="luxury-card p-6">
                        <p>No available rooms at the moment.</p>
                    </div>
                @endforelse
            </div>
        </div>

        {{-- Room Cards --}}
        <h2 class="luxury-heading text-2xl mb-8">Available Rooms</h2>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse($rooms as $room)
                <div class="luxury-card overflow-hidden">
                    @if($room->image)
                        <img src="{{ asset('storage/' . $room->image) }}"
                             alt="{{ $room->room_type }}"
                             class="room-image">
                    @else
                        <div class="no-image-box">
                            No Image Available
                        </div>
                    @endif

                    <div class="p-6">
                        <h3 class="luxury-card-title text-xl mb-4">
                            {{ $room->room_type }}
                        </h3>

                        <p class="mb-2">
                            <strong>Room Number:</strong> {{ $room->room_number }}
                        </p>

                        <p class="mb-2">
                            <strong>Capacity:</strong> {{ $room->capacity }} guest/s
                        </p>

                        <p class="mb-2">
                            <strong>Rate:</strong>
                            <span class="luxury-gold-text font-bold">
                                ₱{{ number_format($room->price, 2) }}
                            </span>
                            per night
                        </p>

                        <p class="mb-5">
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