@extends('layouts.app')

@section('content')
<div class="luxury-page">
    <div class="max-w-4xl mx-auto py-8 px-4">
        <h1 class="luxury-heading text-3xl mb-6">Add New Room</h1>

        <div class="luxury-card p-6">
            <form action="{{ route('admin.rooms.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="mb-4">
                    <label class="block font-semibold mb-1">Room Number</label>
                    <input type="text" name="room_number" value="{{ old('room_number') }}" class="w-full border rounded p-2" required>
                    @error('room_number') <p class="text-red-600">{{ $message }}</p> @enderror
                </div>

                <div class="mb-4">
                    <label class="block font-semibold mb-1">Room Type</label>
                    <input type="text" name="room_type" value="{{ old('room_type') }}" class="w-full border rounded p-2" required>
                    @error('room_type') <p class="text-red-600">{{ $message }}</p> @enderror
                </div>

                <div class="mb-4">
                    <label class="block font-semibold mb-1">Price</label>
                    <input type="number" name="price" value="{{ old('price') }}" class="w-full border rounded p-2" required>
                    @error('price') <p class="text-red-600">{{ $message }}</p> @enderror
                </div>

                <div class="mb-4">
                    <label class="block font-semibold mb-1">Capacity</label>
                    <input type="number" name="capacity" value="{{ old('capacity') }}" class="w-full border rounded p-2" required>
                    @error('capacity') <p class="text-red-600">{{ $message }}</p> @enderror
                </div>

                <div class="mb-4">
                    <label class="block font-semibold mb-1">Description</label>
                    <textarea name="description" class="w-full border rounded p-2">{{ old('description') }}</textarea>
                    @error('description') <p class="text-red-600">{{ $message }}</p> @enderror
                </div>

                <div class="mb-4">
    <label class="block font-semibold mb-1">Room Image</label>
    <input type="file" name="image" class="w-full border rounded p-2" accept="image/*">
    @error('image')
        <p class="text-red-600">{{ $message }}</p>
    @enderror
</div>

                <div class="mb-6">
                    <label class="block font-semibold mb-1">Status</label>
                    <select name="status" class="w-full border rounded p-2" required>
                        <option value="available">Available</option>
                        <option value="unavailable">Unavailable</option>
                        <option value="maintenance">Maintenance</option>
                    </select>
                    @error('status') <p class="text-red-600">{{ $message }}</p> @enderror
                </div>

                <button type="submit" class="luxury-btn" style="border: none; cursor: pointer;">
                    Save Room
                </button>

                <a href="{{ route('admin.rooms.index') }}" class="luxury-btn-navy">
                    Cancel
                </a>
            </form>
        </div>
    </div>
</div>
@endsection