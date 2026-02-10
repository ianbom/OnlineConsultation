<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class RefundController extends Controller
{
    public function index()
    {
        $paymentRefunds = Payment::with('booking.client')->where('status', 'refund')->get();
        return view('admin.refund.index', ['paymentRefunds' => $paymentRefunds]);
    }

    public function show($paymentId)
    {
        $paymentRefund = Payment::with('booking.client')->findOrFail($paymentId);
        return view('admin.refund.detail', ['paymentRefund' => $paymentRefund]);
    }

    public function changeRefundStatus(Request $request, $paymentId)
    {
        $request->validate([
            'refundStatus' => 'required|in:approved,cancelled'
        ]);

        try {
            DB::transaction(function () use ($request, $paymentId) {
                $payment = Payment::with('booking')->findOrFail($paymentId);
                $booking = $payment->booking;

                if ($request->refundStatus === 'approved') {
                    $payment->update(['status' => 'refunded']);
                    $booking->update(['refund_status' => 'done']);
                } elseif ($request->refundStatus === 'cancelled') {
                    $payment->update(['status' => 'refund']);
                    $booking->update(['refund_status' => 'requested']);
                }
            });

            return back()->with('success', 'Status refund berhasil diperbarui.');
        } catch (\Throwable $th) {
            Log::error('Change refund status failed: ' . $th->getMessage());
            return back()->with('error', 'Gagal memperbarui status refund.');
        }
    }
}

