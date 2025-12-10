<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Midtrans\Transaction;

class PaymentController extends Controller
{
    public static function applyStatus($booking, $payment, $status, $fraudStatus = null, $request = null){
        switch ($status) {

            case 'capture': // Credit card
                if ($fraudStatus === 'challenge') {
                    $payment->status = 'pending';
                    $booking->status = 'pending_payment';
                } else {
                    $payment->status = 'success';
                    $booking->status = 'paid';
                    $payment->paid_at = now();
                }
                break;

            case 'settlement': // Transfer Bank / QRIS
                $payment->status = 'success';
                $payment->fraud_status = $fraudStatus;
                $booking->status = 'paid';
                $payment->paid_at = now();
                break;

            case 'pending':
                $payment->status = 'pending';
                $booking->status = 'pending_payment';
                break;

            case 'deny':
                $payment->status = 'failed';
                $payment->failure_reason = 'deny';
                $booking->status = 'cancelled';
                $booking->cancelled_by = 'system';
                $booking->cancel_reason = 'Pembayaran ditolak Midtrans';
                $booking->cancelled_at = now();
                break;

            case 'cancel':
                $payment->status = 'failed';
                $payment->failure_reason = 'cancel';
                $booking->status = 'cancelled';
                $booking->cancelled_by = 'client';
                $booking->cancel_reason = 'Client membatalkan pembayaran.';
                $booking->cancelled_at = now();
                break;

            case 'expire':
                Log::info('Kadaluarsa');

                $payment->status = 'failed';
                $payment->failure_reason = 'expire';

                $booking->status = 'cancelled';
                $booking->is_expired = true;
                $booking->cancelled_by = 'system';
                $booking->cancel_reason = 'Pembayaran kedaluwarsa.';
                $booking->cancelled_at = now();
                break;

            case 'refund':
                $payment->status = 'refund';
                $payment->refund_amount = $request->refund_amount ?? $payment->amount;
                $payment->refund_reason = $request->reason ?? 'Refund oleh Midtrans';
                $payment->refund_time = now();

                $booking->status = 'cancelled';
                $booking->refund_status = 'processed';
                $booking->refund_processed_at = now();
                break;

            default:
                $payment->status = 'failed';
                $payment->failure_reason = "unknown:$status";

                $booking->status = 'cancelled';
                $booking->cancelled_at = now();
                break;
        }

        return [$booking, $payment];
    }

    public function checkPayment(Booking $booking)
    {
        $payment = $booking->payment;

        if (!$payment) {
            return back()->with('error', 'Pembayaran tidak ditemukan.');
        }

        try {
            $response = Transaction::status($payment->order_id);

            $status        = $response->transaction_status;
            $fraudStatus   = $response->fraud_status ?? null;

            // Simpan status Midtrans
            $payment->transaction_status = $status;
            $payment->midtrans_transaction_id = $response->transaction_id ?? null;
            $payment->payment_type = $response->payment_type ?? null;
            $payment->fraud_status = $fraudStatus;

            // Terapkan logika status yang sama
            [$booking, $payment] = self::applyStatus(
                $booking,
                $payment,
                $status,
                $fraudStatus
            );

            $payment->save();
            $booking->save();

            return back()->with('success', "Status pembayaran diperbarui: $status");

        } catch (\Exception $e) {
            return back()->with('error', 'Gagal memeriksa pembayaran.');
        }
    }



    public function handle(Request $request)
    {
        Log::info('Midtrans Callback Received', $request->all());

        $payment = Payment::where('order_id', $request->order_id)->first();

        if (!$payment) {
            Log::error("Payment not found for order: {$request->order_id}");
            return response()->json(['message' => 'Payment not found'], 404);
        }

        $booking = $payment->booking;
        $status = $request->transaction_status;
        $fraudStatus = $request->fraud_status ?? null;

        $payment->transaction_status = $status;
        $payment->payment_type = $request->payment_type ?? $payment->payment_type;
        $payment->va_number = $request->va_numbers[0]['va_number'] ?? null;
        $payment->settlement_time = $request->settlement_time ?? null;
        $payment->midtrans_transaction_id = $request->transaction_id;

        [$booking, $payment] = self::applyStatus(
            $booking,
            $payment,
            $status,
            $fraudStatus,
            $request
        );

        $payment->save();
        $booking->save();

        return response()->json(['message' => 'Callback processed'], 200);
    }
}
