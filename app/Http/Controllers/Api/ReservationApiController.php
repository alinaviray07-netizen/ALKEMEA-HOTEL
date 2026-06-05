<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Reservation;
use App\Models\Room;
use Illuminate\Http\Request;
use Carbon\Carbon;

class ReservationApiController extends Controller
{
    public function index()
    {
        return response()->json([
            'message' => 'Reservations fetched successfully.',
            'data' => Reservation::with(['user', 'room', 'payment'])->latest()->get(),
        ]);
    }

    public function show(Reservation $reservation)
    {
        $reservation->load(['user', 'room', 'payment']);

        return response()->json([
            'message' => 'Reservation fetched successfully.',
            'data' => $reservation,
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'user_id' => 'required|exists:users,id',
            'room_id' => 'required|exists:rooms,id',
            'check_in_date' => 'required|date',
            'check_out_date' => 'required|date|after:check_in_date',
            'status' => 'nullable|in:pending,approved,rejected,cancelled',
        ]);

        $room = Room::findOrFail($data['room_id']);

        $checkIn = Carbon::parse($data['check_in_date']);
        $checkOut = Carbon::parse($data['check_out_date']);

        $data['total_price'] = $checkIn->diffInDays($checkOut) * $room->price;
        $data['status'] = $data['status'] ?? 'pending';

        $reservation = Reservation::create($data);

        return response()->json([
            'message' => 'Reservation created successfully.',
            'data' => $reservation,
        ], 201);
    }

    public function update(Request $request, Reservation $reservation)
    {
        $data = $request->validate([
            'status' => 'sometimes|required|in:pending,approved,rejected,cancelled',
            'rejection_reason' => 'nullable|string|max:1000',
        ]);

        $reservation->update($data);

        return response()->json([
            'message' => 'Reservation updated successfully.',
            'data' => $reservation,
        ]);
    }

    public function destroy(Reservation $reservation)
    {
        $reservation->delete();

        return response()->json([
            'message' => 'Reservation deleted successfully.',
        ]);
    }
}