@extends('layouts.app')

@section('content')
<div class="luxury-page">
    <div class="max-w-7xl mx-auto py-8 px-4">
        <div class="flex flex-wrap justify-between items-center gap-3 mb-6">
            <div>
                <h1 class="luxury-heading text-3xl">Manage Rooms</h1>
                <p class="text-sm text-gray-600 mt-1">
                    Manage room details, rates, capacity, and availability.
                </p>
            </div>
            <a href="{{ route('admin.rooms.import.form') }}" class="btn-navy">
    Import Rooms
</a>

            <a href="{{ route('admin.rooms.create') }}" class="btn-luxury">
                Add Room
            </a>
        </div>

        @if(session('success'))
            <div class="mb-4 p-4 rounded bg-green-100 text-green-700">
                {{ session('success') }}
            </div>
        @endif

        <div class="luxury-card p-6">
            <div class="table-wrapper">
                <table class="luxury-table">
                    <thead>
                        <tr>
                            <th>Room Number</th>
                            <th>Room Type</th>
                            <th>Rate per Night</th>
                            <th>Capacity</th>
                            <th>Status</th>
                            <th>Options</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($rooms as $room)
                            <tr>
                                <td>{{ $room->room_number }}</td>
                                <td>{{ $room->room_type }}</td>
                                <td>₱{{ number_format($room->price, 2) }}</td>
                                <td>{{ $room->capacity }} guest/s</td>
                                <td>{{ ucfirst($room->status) }}</td>

                                <td>
                                    <div class="table-actions">
                                        <a href="{{ route('admin.rooms.edit', $room) }}" class="btn-navy">
                                            Edit
                                        </a>

                                        <form action="{{ route('admin.rooms.destroy', $room) }}" method="POST" onsubmit="return confirm('Delete this room?')">
                                            @csrf
                                            @method('DELETE')

                                            <button type="submit" class="btn-luxury">
                                                Delete
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center">
                                    No rooms available.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div class="mt-6">
            <a href="{{ route('admin.dashboard') }}" class="btn-navy">
                Back
            </a>
        </div>
    </div>
</div>
@endsection