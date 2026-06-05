<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Room;
use Illuminate\Http\Request;

class RoomApiController extends Controller
{
    public function index()
    {
        return response()->json([
            'message' => 'Rooms fetched successfully.',
            'data' => Room::latest()->get(),
        ]);
    }

    public function show(Room $room)
    {
        return response()->json([
            'message' => 'Room fetched successfully.',
            'data' => $room,
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'room_number' => 'required|string|max:255|unique:rooms,room_number',
            'room_type' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'capacity' => 'required|integer|min:1',
            'description' => 'nullable|string',
            'status' => 'required|in:available,unavailable,maintenance',
        ]);

        $room = Room::create($data);

        return response()->json([
            'message' => 'Room created successfully.',
            'data' => $room,
        ], 201);
    }

    public function update(Request $request, Room $room)
    {
        $data = $request->validate([
            'room_number' => 'sometimes|required|string|max:255|unique:rooms,room_number,' . $room->id,
            'room_type' => 'sometimes|required|string|max:255',
            'price' => 'sometimes|required|numeric|min:0',
            'capacity' => 'sometimes|required|integer|min:1',
            'description' => 'nullable|string',
            'status' => 'sometimes|required|in:available,unavailable,maintenance',
        ]);

        $room->update($data);

        return response()->json([
            'message' => 'Room updated successfully.',
            'data' => $room,
        ]);
    }

    public function destroy(Room $room)
    {
        $room->delete();

        return response()->json([
            'message' => 'Room deleted successfully.',
        ]);
    }
}