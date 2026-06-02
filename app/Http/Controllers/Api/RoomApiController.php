<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Room;

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
}