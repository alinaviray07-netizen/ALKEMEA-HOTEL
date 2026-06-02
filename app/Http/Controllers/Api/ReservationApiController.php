<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Reservation;
use App\Models\Room;
use App\Models\Payment;
use Illuminate\Http\Request;
use Carbon\Carbon;

class ReservationApiController extends Controller
{
    public function index()
    {
        $reservations = Reservation::with(['user', 'room', 'payment'])->latest()->get();

        return response()->json([
            'message' => 'Reservations fetched successfully.',
            'data' => $reservations,
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'room_id' => 'required|exists:rooms,id',
            'check_in_date' => 'required|date',
            'check_out_date' => 'required|date|after:check_in_date',
        ]);

        $room = Room::findOrFail($request->room_id);

        $checkIn = Carbon::parse($request->check_in_date);
        $checkOut = Carbon::parse($request->check_out_date);
        $nights = $checkIn->diffInDays($checkOut);
        $totalPrice = $nights * $room->price;

        $reservation = Reservation::create([
            'user_id' => $request->user_id,
            'room_id' => $request->room_id,
            'check_in_date' => $request->check_in_date,
            'check_out_date' => $request->check_out_date,
            'total_price' => $totalPrice,
            'status' => 'pending',
        ]);

        Payment::create([
            'reservation_id' => $reservation->id,
            'amount' => $totalPrice,
            'payment_method' => 'cash',
            'status' => 'unpaid',
            'payment_date' => null,
        ]);

        return response()->json([
            'message' => 'Reservation created successfully.',
            'data' => $reservation,
        ], 201);
    }

    public function update(Request $request, Reservation $reservation)
    {
        $request->validate([
            'status' => 'required|in:pending,approved,rejected,cancelled,completed',
        ]);

        $reservation->update([
            'status' => $request->status,
        ]);

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