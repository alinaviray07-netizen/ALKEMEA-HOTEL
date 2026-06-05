<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
use App\Models\Room;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class ReservationController extends Controller
{
    public function index()
    {
        if (Auth::user()->role === 'admin') {
            return redirect()->route('admin.reservations.index');
        }

        $reservations = Reservation::with(['room', 'payment'])
            ->where('user_id', Auth::id())
            ->latest()
            ->get();

        return view('reservations.index', compact('reservations'));
    }

    public function create(Request $request)
    {
        if (Auth::user()->role === 'admin') {
            return redirect()
                ->route('admin.dashboard')
                ->with('error', 'Admins cannot make room reservations.');
        }

        $room = Room::findOrFail($request->room_id);

        if ($room->status !== 'available') {
            return redirect()
                ->route('home')
                ->with('error', 'This room is no longer available.');
        }

        return view('reservations.create', compact('room'));
    }

    public function store(Request $request)
    {
        if (Auth::user()->role === 'admin') {
            return redirect()
                ->route('admin.dashboard')
                ->with('error', 'Admins cannot make room reservations.');
        }

        $request->validate([
            'room_id' => 'required|exists:rooms,id',
            'check_in_date' => 'required|date|after_or_equal:today',
            'check_out_date' => 'required|date|after:check_in_date',
            'payment_method' => 'required|in:cash,gcash,bank transfer,card',

            'payment_account_name' => 'nullable|string|max:255',
            'payment_account_number' => 'nullable|string|max:255',
            'bank_name' => 'nullable|string|max:255',
            'payment_reference' => 'nullable|string|max:255',
            'card_last_four' => 'nullable|string|max:4',
            'payment_note' => 'nullable|string|max:1000',
        ]);

        if ($request->payment_method === 'gcash') {
            $request->validate([
                'payment_account_name' => 'required|string|max:255',
                'payment_account_number' => 'required|string|max:255',
                'payment_reference' => 'required|string|max:255',
            ]);
        }

        if ($request->payment_method === 'bank transfer') {
            $request->validate([
                'bank_name' => 'required|string|max:255',
                'payment_account_name' => 'required|string|max:255',
                'payment_account_number' => 'required|string|max:255',
                'payment_reference' => 'required|string|max:255',
            ]);
        }

        if ($request->payment_method === 'card') {
            $request->validate([
                'payment_account_name' => 'required|string|max:255',
                'card_last_four' => 'required|string|size:4',
            ]);
        }

        $room = Room::findOrFail($request->room_id);

        if ($room->status !== 'available') {
            return back()->with('error', 'This room is not available.');
        }

        $checkIn = Carbon::parse($request->check_in_date);
        $checkOut = Carbon::parse($request->check_out_date);
        $nights = $checkIn->diffInDays($checkOut);
        $totalPrice = $nights * $room->price;

        $reservation = Reservation::create([
            'user_id' => Auth::id(),
            'room_id' => $room->id,
            'check_in_date' => $request->check_in_date,
            'check_out_date' => $request->check_out_date,
            'total_price' => $totalPrice,
            'status' => 'pending',
            'rejection_reason' => null,
        ]);

        Payment::create([
            'reservation_id' => $reservation->id,
            'amount' => $totalPrice,
            'payment_method' => $request->payment_method,
            'payment_account_name' => $request->payment_account_name,
            'payment_account_number' => $request->payment_account_number,
            'bank_name' => $request->bank_name,
            'payment_reference' => $request->payment_reference,
            'card_last_four' => $request->card_last_four,
            'payment_note' => $request->payment_note,
            'status' => 'unpaid',
            'payment_date' => null,
        ]);

        return redirect()
            ->route('reservations.index')
            ->with('success', 'Reservation submitted successfully. Please wait for admin approval.');
    }

    public function show(Reservation $reservation)
    {
        if ($reservation->user_id !== Auth::id() && Auth::user()->role !== 'admin') {
            abort(403);
        }

        $reservation->load(['room', 'payment']);

        return view('reservations.show', compact('reservation'));
    }

    public function destroy(Reservation $reservation)
    {
        if (Auth::user()->role === 'admin') {
            return redirect()
                ->route('admin.reservations.index')
                ->with('error', 'Admins cannot cancel reservations from the guest side.');
        }

        if ($reservation->user_id !== Auth::id()) {
            abort(403);
        }

        if ($reservation->status === 'approved') {
            return back()->with('error', 'Approved reservations cannot be cancelled here. Please contact the admin.');
        }

        $reservation->update([
            'status' => 'cancelled',
        ]);

        return redirect()
            ->route('reservations.index')
            ->with('success', 'Reservation cancelled successfully.');
    }

    public function adminIndex()
    {
        $reservations = Reservation::with(['user', 'room', 'payment'])
            ->latest()
            ->get();

        return view('admin.reservations.index', compact('reservations'));
    }

    public function approve(Reservation $reservation)
    {
        $reservation->load(['room', 'payment']);

        if ($reservation->room && $reservation->room->status !== 'available') {
            return redirect()
                ->route('admin.reservations.index')
                ->with('error', 'This room is already unavailable.');
        }

        $reservation->update([
            'status' => 'approved',
            'rejection_reason' => null,
        ]);

        if ($reservation->payment) {
            $reservation->payment->update([
                'status' => 'paid',
                'payment_date' => now(),
            ]);
        }

        if ($reservation->room) {
            $reservation->room->update([
                'status' => 'unavailable',
            ]);
        }

        return redirect()
            ->route('admin.reservations.index')
            ->with('success', 'Reservation approved successfully. The room is now unavailable.');
    }

    public function reject(Request $request, Reservation $reservation)
    {
        $request->validate([
            'rejection_reason' => 'required|string|max:1000',
        ]);

        $reservation->load(['room', 'payment']);

        $reservation->update([
            'status' => 'rejected',
            'rejection_reason' => $request->rejection_reason,
        ]);

        if ($reservation->payment) {
            $reservation->payment->update([
                'status' => 'unpaid',
                'payment_date' => null,
            ]);
        }

        if ($reservation->room) {
            $reservation->room->update([
                'status' => 'available',
            ]);
        }

        return redirect()
            ->route('admin.reservations.index')
            ->with('success', 'Reservation rejected successfully. Reason has been sent to the user.');
    }
}