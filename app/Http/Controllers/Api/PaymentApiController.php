<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use Illuminate\Http\Request;

class PaymentApiController extends Controller
{
    public function index()
    {
        return response()->json([
            'message' => 'Payments fetched successfully.',
            'data' => Payment::with(['reservation.user', 'reservation.room'])->latest()->get(),
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'reservation_id' => 'required|exists:reservations,id',
            'amount' => 'required|numeric|min:0',
            'payment_method' => 'required|in:cash,gcash,bank transfer,card',
            'payment_account_name' => 'nullable|string|max:255',
            'payment_account_number' => 'nullable|string|max:255',
            'bank_name' => 'nullable|string|max:255',
            'payment_reference' => 'nullable|string|max:255',
            'card_last_four' => 'nullable|string|max:4',
            'payment_note' => 'nullable|string|max:1000',
            'status' => 'required|in:unpaid,paid,failed,refunded',
            'payment_date' => 'nullable|date',
        ]);

        $payment = Payment::create($data);

        return response()->json([
            'message' => 'Payment created successfully.',
            'data' => $payment,
        ], 201);
    }

    public function update(Request $request, Payment $payment)
    {
        $data = $request->validate([
            'amount' => 'sometimes|required|numeric|min:0',
            'payment_method' => 'sometimes|required|in:cash,gcash,bank transfer,card',
            'payment_account_name' => 'nullable|string|max:255',
            'payment_account_number' => 'nullable|string|max:255',
            'bank_name' => 'nullable|string|max:255',
            'payment_reference' => 'nullable|string|max:255',
            'card_last_four' => 'nullable|string|max:4',
            'payment_note' => 'nullable|string|max:1000',
            'status' => 'sometimes|required|in:unpaid,paid,failed,refunded',
            'payment_date' => 'nullable|date',
        ]);

        $payment->update($data);

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