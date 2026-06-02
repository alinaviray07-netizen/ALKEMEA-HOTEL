<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use Illuminate\Http\Request;

class PaymentApiController extends Controller
{
    public function index()
    {
        $payments = Payment::with(['reservation.user', 'reservation.room'])->latest()->get();

        return response()->json([
            'message' => 'Payments fetched successfully.',
            'data' => $payments,
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'reservation_id' => 'required|exists:reservations,id',
            'amount' => 'required|numeric|min:0',
            'payment_method' => 'nullable|string',
            'status' => 'required|in:unpaid,paid,refunded',
        ]);

        $payment = Payment::create([
            'reservation_id' => $request->reservation_id,
            'amount' => $request->amount,
            'payment_method' => $request->payment_method,
            'status' => $request->status,
            'payment_date' => $request->status === 'paid' ? now() : null,
        ]);

        return response()->json([
            'message' => 'Payment created successfully.',
            'data' => $payment,
        ], 201);
    }

    public function update(Request $request, Payment $payment)
    {
        $request->validate([
            'status' => 'required|in:unpaid,paid,refunded',
            'payment_method' => 'nullable|string',
        ]);

        $payment->update([
            'status' => $request->status,
            'payment_method' => $request->payment_method,
            'payment_date' => $request->status === 'paid' ? now() : null,
        ]);

        return response()->json([
            'message' => 'Payment updated successfully.',
            'data' => $payment,
        ]);
    }

    public function destroy(Payment $payment)
    {
        $payment->delete();

        return response()->json([
            'message' => 'Payment deleted successfully.',
        ]);
    }
}