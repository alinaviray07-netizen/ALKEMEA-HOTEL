@extends('layouts.app')

@section('content')
<div class="luxury-page">
    <div class="max-w-5xl mx-auto py-8 px-4">
        <a href="{{ route('home') }}" class="btn-navy mb-6">
            Back
        </a>

        <div class="luxury-card overflow-hidden mt-6">
            @if($roomSample->image)
                <img src="{{ asset('storage/' . $roomSample->image) }}"
                     alt="{{ $roomType }}"
                     style="width: 100%; height: 320px; object-fit: cover;">
            @else
                <div class="no-image-box">
                    No Image Available
                </div>
            @endif

            <div class="p-6">
                <h1 class="luxury-heading text-3xl mb-4">
                    {{ $roomType }}
                </h1>

                <p class="mb-2">
                    <strong>Capacity:</strong> {{ $roomSample->capacity }} guest/s
                </p>

                <p class="mb-2">
                    <strong>Rate:</strong>
                    <span class="luxury-gold-text font-bold">
                        ₱{{ number_format($roomSample->price, 2) }}
                    </span>
                    per night
                </p>

                <p class="mb-6">
                    <strong>Description:</strong>
                    {{ $roomSample->description ?? 'No description available.' }}
                </p>

                <h2 class="luxury-card-title text-xl mb-4">
                    Choose Available Room Number
                </h2>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    @foreach($rooms as $room)
                        <div class="luxury-card p-4">
                            <h3 class="font-bold text-lg mb-2">
                                Room {{ $room->room_number }}
                            </h3>

                            <p class="mb-2">
                                <strong>Status:</strong> {{ ucfirst($room->status) }}
                            </p>

                            @auth
                                @if(auth()->user()->role === 'admin')
                                    <a href="{{ route('rooms.show', $room) }}" class="btn-navy">
                                        View Room
                                    </a>
                                @else
                                    <a href="{{ route('reservations.create', ['room_id' => $room->id]) }}" class="btn-luxury">
                                        Reserve This Room
                                    </a>
                                @endif
                            @else
                                <a href="{{ route('login') }}" class="btn-luxury">
                                    Login to Reserve
                                </a>
                            @endauth
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@endsection