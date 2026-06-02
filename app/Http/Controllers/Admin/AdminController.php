<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Room;
use App\Models\Reservation;
use App\Models\Payment;
use App\Models\User;

class AdminController extends Controller
{
    public function dashboard()
    {
        $totalRooms = Room::count();
        $availableRooms = Room::where('status', 'available')->count();
        $totalReservations = Reservation::count();
        $pendingReservations = Reservation::where('status', 'pending')->count();
        $totalPayments = Payment::count();
        $totalUsers = User::where('role', 'guest')->count();

        return view('admin.dashboard', compact(
            'totalRooms',
            'availableRooms',
            'totalReservations',
            'pendingReservations',
            'totalPayments',
            'totalUsers'
        ));
    }

    public function reports()
    {
        $reservations = Reservation::with(['user', 'room', 'payment'])
            ->latest()
            ->get();

        $totalReservations = Reservation::count();
        $approvedReservations = Reservation::where('status', 'approved')->count();
        $pendingReservations = Reservation::where('status', 'pending')->count();
        $rejectedReservations = Reservation::where('status', 'rejected')->count();
        $cancelledReservations = Reservation::where('status', 'cancelled')->count();
        $totalRevenue = Payment::where('status', 'paid')->sum('amount');

        return view('admin.reports', compact(
            'reservations',
            'totalReservations',
            'approvedReservations',
            'pendingReservations',
            'rejectedReservations',
            'cancelledReservations',
            'totalRevenue'
        ));
    }

    public function exportJson()
    {
        $reservations = Reservation::with(['user', 'room', 'payment'])
            ->latest()
            ->get();

        return response()->json([
            'message' => 'Reservation report exported successfully.',
            'data' => $reservations,
        ]);
    }
}