<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function index()
    {
        $payments = Payment::with(['reservation.user', 'reservation.room'])
            ->latest()
            ->get();

        return view('admin.payments.index', compact('payments'));
    }

    public function show(Payment $payment)
    {
        $payment->load(['reservation.user', 'reservation.room']);

        return view('admin.payments.show', compact('payment'));
    }

    public function update(Request $request, Payment $payment)
    {
        $request->validate([
    'status' => 'required|in:unpaid,paid,refunded',
    'payment_method' => 'required|in:cash,gcash,bank transfer,card',
]);

        $payment->update([
    'status' => $request->status,
    'payment_method' => $request->payment_method,
    'payment_date' => $request->status === 'paid' ? now() : null,
]);

        return redirect()
            ->route('admin.payments.index')
            ->with('success', 'Payment updated successfully.');
    }

    public function destroy(Payment $payment)
    {
        $payment->delete();

        return redirect()
            ->route('admin.payments.index')
            ->with('success', 'Payment deleted successfully.');
    }
}