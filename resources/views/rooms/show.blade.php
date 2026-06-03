@extends('layouts.app')

@section('content')
<div class="luxury-page">
    <div class="max-w-4xl mx-auto py-8 px-4">
        <a href="{{ route('home') }}" class="btn-navy mb-6">
            Back
        </a>

        <div class="luxury-card overflow-hidden mt-6">
            @if($room->image)
                <img src="{{ asset('storage/' . $room->image) }}"
                     alt="{{ $room->room_type }}"
                     style="width: 100%; height: 320px; object-fit: cover;">
            @else
                <div class="no-image-box">
                    No Image Available
                </div>
            @endif

            <div class="p-6">
                <h1 class="luxury-heading text-3xl mb-4">
                    {{ $room->room_type }}
                </h1>

                <p class="mb-2"><strong>Room Number:</strong> {{ $room->room_number }}</p>
                <p class="mb-2"><strong>Capacity:</strong> {{ $room->capacity }} guest/s</p>

                <p class="mb-2">
                    <strong>Rate:</strong>
                    <span class="luxury-gold-text font-bold">
                        ₱{{ number_format($room->price, 2) }}
                    </span>
                    per night
                </p>

                <p class="mb-2"><strong>Status:</strong> {{ ucfirst($room->status) }}</p>

                <p class="mb-6">
                    <strong>Description:</strong>
                    {{ $room->description ?? 'No description available.' }}
                </p>

                @auth
                    @if(auth()->user()->role === 'admin')
                        <a href="{{ route('admin.dashboard') }}" class="btn-navy">
                            Back to Admin Dashboard
                        </a>
                    @else
                        <a href="{{ route('reservations.create', ['room_id' => $room->id]) }}" class="btn-luxury">
                            Reserve Room
                        </a>
                    @endif
                @else
                    <a href="{{ route('login') }}" class="btn-luxury">
                        Login to Reserve
                    </a>
                @endauth
            </div>
        </div>
    </div>
</div>
@endsection