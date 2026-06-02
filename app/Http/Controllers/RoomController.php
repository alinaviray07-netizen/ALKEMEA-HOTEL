<?php

namespace App\Http\Controllers;

use App\Models\Room;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class RoomController extends Controller
{
    /**
     * Display available rooms for guests/public homepage.
     */
    public function index()
    {
        $rooms = Room::where('status', 'available')
            ->latest()
            ->get();

        return view('rooms.index', compact('rooms'));
    }

    /**
     * Display all rooms for admin.
     */
    public function adminIndex()
    {
        $rooms = Room::latest()->get();

        return view('admin.rooms.index', compact('rooms'));
    }

    /**
     * Show the form for creating a new room.
     */
    public function create()
    {
        return view('admin.rooms.create');
    }

    /**
     * Store a newly created room.
     */
    public function store(Request $request)
{
    $request->validate([
        'room_number' => 'required|string|max:255|unique:rooms,room_number',
        'room_type' => 'required|string|max:255',
        'price' => 'required|numeric|min:0',
        'capacity' => 'required|integer|min:1',
        'description' => 'nullable|string',
        'status' => 'required|in:available,unavailable,maintenance',
        'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
    ]);

    $imagePath = null;

    if ($request->hasFile('image')) {
        $imagePath = $request->file('image')->store('rooms', 'public');
    }

    Room::create([
        'room_number' => $request->room_number,
        'room_type' => $request->room_type,
        'price' => $request->price,
        'capacity' => $request->capacity,
        'description' => $request->description,
        'status' => $request->status,
        'image' => $imagePath,
    ]);

    return redirect()
        ->route('admin.rooms.index')
        ->with('success', 'Room added successfully.');
}

    /**
     * Display the specified room for guests/public.
     */
    public function show(Room $room)
    {
        return view('rooms.show', compact('room'));
    }

    /**
     * Show the form for editing the specified room.
     */
    public function edit(Room $room)
    {
        return view('admin.rooms.edit', compact('room'));
    }

    /**
     * Update the specified room.
     */
    public function update(Request $request, Room $room)
{
    $request->validate([
        'room_number' => 'required|string|max:255|unique:rooms,room_number,' . $room->id,
        'room_type' => 'required|string|max:255',
        'price' => 'required|numeric|min:0',
        'capacity' => 'required|integer|min:1',
        'description' => 'nullable|string',
        'status' => 'required|in:available,unavailable,maintenance',
        'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
    ]);

    $imagePath = $room->image;

    if ($request->hasFile('image')) {
        if ($room->image) {
            Storage::disk('public')->delete($room->image);
        }

        $imagePath = $request->file('image')->store('rooms', 'public');
    }

    $room->update([
        'room_number' => $request->room_number,
        'room_type' => $request->room_type,
        'price' => $request->price,
        'capacity' => $request->capacity,
        'description' => $request->description,
        'status' => $request->status,
        'image' => $imagePath,
    ]);

    return redirect()
        ->route('admin.rooms.index')
        ->with('success', 'Room updated successfully.');
}

    /**
     * Remove the specified room.
     */
    public function destroy(Room $room)
    {
        $room->delete();

        return redirect()
            ->route('admin.rooms.index')
            ->with('success', 'Room deleted successfully.');
    }
}