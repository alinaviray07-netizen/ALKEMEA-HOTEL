@extends('layouts.app')

@section('content')
<div class="container py-4">
    <a href="{{ route('home') }}"
       style="display: inline-block; margin-bottom: 15px; padding: 8px 12px; background: #6c757d; color: white; text-decoration: none; border-radius: 5px;">
        Back
    </a>

    <div style="border: 1px solid #ddd; padding: 20px; border-radius: 8px;">
        <h1>{{ $room->room_type }}</h1>

        <p><strong>Room Number:</strong> {{ $room->room_number }}</p>
        <p><strong>Capacity:</strong> {{ $room->capacity }} person/s</p>
        <p><strong>Price:</strong> ₱{{ number_format($room->price, 2) }} per night</p>
        <p><strong>Status:</strong> {{ ucfirst($room->status) }}</p>
        <p><strong>Description:</strong> {{ $room->description }}</p>

        @auth
            <a href="{{ route('reservations.create', ['room_id' => $room->id]) }}"
               style="display: inline-block; padding: 10px 15px; background: #198754; color: white; text-decoration: none; border-radius: 5px;">
                Reserve This Room
            </a>
        @else
            <a href="{{ route('login') }}"
               style="display: inline-block; padding: 10px 15px; background: #198754; color: white; text-decoration: none; border-radius: 5px;">
                Login to Reserve
            </a>
        @endauth
    </div>
</div>
@endsection