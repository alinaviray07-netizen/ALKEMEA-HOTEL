@extends('layouts.app')

@section('content')
<div class="luxury-page">
    <div class="max-w-4xl mx-auto py-8 px-4">
        <h1 class="luxury-heading text-3xl mb-6">Edit Room</h1>

        <div class="luxury-card p-6">
            <form action="{{ route('admin.rooms.update', $room) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PATCH')

                <div class="mb-4">
                    <label class="block font-semibold mb-1">Room Number</label>
                    <input type="text" name="room_number" value="{{ old('room_number', $room->room_number) }}" class="w-full border rounded p-2" required>
                    @error('room_number') <p class="text-red-600">{{ $message }}</p> @enderror
                </div>

                <div class="mb-4">
                    <label class="block font-semibold mb-1">Room Type</label>
                    <input type="text" name="room_type" value="{{ old('room_type', $room->room_type) }}" class="w-full border rounded p-2" required>
                    @error('room_type') <p class="text-red-600">{{ $message }}</p> @enderror
                </div>

                <div class="mb-4">
                    <label class="block font-semibold mb-1">Price</label>
                    <input type="number" name="price" value="{{ old('price', $room->price) }}" class="w-full border rounded p-2" required>
                    @error('price') <p class="text-red-600">{{ $message }}</p> @enderror
                </div>

                <div class="mb-4">
                    <label class="block font-semibold mb-1">Capacity</label>
                    <input type="number" name="capacity" value="{{ old('capacity', $room->capacity) }}" class="w-full border rounded p-2" required>
                    @error('capacity') <p class="text-red-600">{{ $message }}</p> @enderror
                </div>

                <div class="mb-4">
                    <label class="block font-semibold mb-1">Description</label>
                    <textarea name="description" class="w-full border rounded p-2">{{ old('description', $room->description) }}</textarea>
                    @error('description') <p class="text-red-600">{{ $message }}</p> @enderror
                </div>

                <div class="mb-4">
    <label class="block font-semibold mb-1">Room Image</label>

    @if($room->image)
        <div class="mb-3">
            <img src="{{ asset('storage/' . $room->image) }}" alt="Room Image" style="width: 180px; height: 120px; object-fit: cover; border-radius: 8px;">
        </div>
    @endif

    <input type="file" name="image" class="w-full border rounded p-2" accept="image/*">

    @error('image')
        <p class="text-red-600">{{ $message }}</p>
    @enderror
</div>

                <div class="mb-6">
                    <label class="block font-semibold mb-1">Status</label>
                    <select name="status" class="w-full border rounded p-2" required>
                        <option value="available" {{ $room->status === 'available' ? 'selected' : '' }}>Available</option>
                        <option value="unavailable" {{ $room->status === 'unavailable' ? 'selected' : '' }}>Unavailable</option>
                        <option value="maintenance" {{ $room->status === 'maintenance' ? 'selected' : '' }}>Maintenance</option>
                    </select>
                    @error('status') <p class="text-red-600">{{ $message }}</p> @enderror
                </div>

                <button type="submit" class="luxury-btn" style="border: none; cursor: pointer;">
                    Update Room
                </button>

                <a href="{{ route('admin.rooms.index') }}" class="luxury-btn-navy">
                    Cancel
                </a>
            </form>
        </div>
    </div>
</div>
@endsection