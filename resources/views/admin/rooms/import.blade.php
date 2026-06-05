@extends('layouts.app')

@section('content')
<div class="luxury-page">
    <div class="max-w-4xl mx-auto py-8 px-4">
        <h1 class="luxury-heading text-3xl mb-6">Import Rooms</h1>

        <div class="luxury-card p-6">
            <p class="text-gray-600 mb-4">
                Upload a CSV or XLSX file to import room records.
            </p>

            <div class="mb-6 p-4 rounded" style="background-color: #F8F6F0; border: 1px solid #D4AF37;">
                <p class="font-bold mb-2">Required file headers:</p>
                <code>
                    room_number, room_type, price, capacity, status, description
                </code>
            </div>

            @if ($errors->any())
                <div class="mb-4 p-4 rounded bg-red-100 text-red-700">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('admin.rooms.import') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="mb-4">
                    <label class="block font-bold mb-2">Choose CSV/XLSX File</label>
                    <input type="file" name="import_file" class="w-full border p-3 rounded" required>
                </div>

                <button type="submit" class="btn-luxury">
                    Import Rooms
                </button>

                <a href="{{ route('admin.rooms.index') }}" class="btn-navy ml-2">
                    Back
                </a>
            </form>
        </div>
    </div>
</div>
@endsection