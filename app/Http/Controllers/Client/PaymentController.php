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

    public function checkPayment(Booking $booking)
    {
        $payment = $booking->payment;

        if (!$payment) {
            return back()->with('error', 'Pembayaran tidak ditemukan.');
        }

        try {
            $response = Transaction::status($payment->order_id);

            $status = $response->transaction_status;



            if (in_array($status, ['settlement', 'capture'])) {

                $payment->update([
                    'status' => 'success',
                    'midtrans_transaction_id' => $response->transaction_id,
                    'payment_type' => $response->payment_type,
                    'fraud_status' => $response->fraud_status ?? null,
                    'paid_at' => now(),
                ]);

                // Update booking
                $booking->update([
                    'status' => 'completed',
                ]);

                return redirect()->back()->with('success', 'Pembayaran berhasil diverifikasi.');
            }

            // Jika masih pending
            if ($status === 'pending') {
                return redirect()->back()->with('warning', 'Pembayaran masih menunggu. Silakan cek kembali.');
            }

            // Jika gagal
            $payment->update(['status' => 'failed']);
            $booking->update(['status' => 'cancelled']);

            return redirect()->back()->with('error', 'Pembayaran gagal atau kadaluarsa.');

            if(!$booking->payment->midtrans_transaction_id){
                return redirect()->back()->with('error', 'Pembayaran belum dilakukan.');
            }

        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal memeriksa pembayaran: ');
        }
    }


    public function handle(Request $request)
    {
        Log::info('Midtrans Callback Received', $request->all());

        $orderId = $request->order_id;
        $transactionStatus = $request->transaction_status;
        $fraudStatus = $request->fraud_status ?? null;

        $payment = Payment::where('order_id', $orderId)->first();
        if (!$payment) {
            Log::error("Payment not found for order: $orderId");
            return response()->json(['message' => 'Payment not found'], 404);
        }

        $booking = $payment->booking;

        // ================================
        // 🔥 HANDLING TRANSACTION STATUS
        // ================================
        switch ($transactionStatus) {

            case 'capture': // CC
                if ($fraudStatus === 'challenge') {
                    $payment->status = 'pending';
                    $booking->status = 'pending_payment';
                } else {
                    $payment->status = 'success';
                    $booking->status = 'paid';
                    $payment->paid_at = now();
                }
                break;

            case 'settlement': // BANK TRANSFER & QRIS
                $payment->status = 'success';
                $booking->status = 'paid';
                $payment->paid_at = now();
                break;

            case 'pending':
                $payment->status = 'pending';
                $booking->status = 'pending_payment';
                break;

            case 'deny':
            case 'cancel':
            case 'expire':
                $payment->status = 'failed';
                $booking->status = 'pending_payment';
                break;

            case 'refund':
                $payment->status = 'refund';
                $booking->status = 'cancelled';
                break;
        }

        // ================================
        // 🔥 SAVE DATA CALLBACK
        // ================================
        $payment->update([
            'payment_type' => $request->payment_type ?? $payment->payment_type,
            'fraud_status' => $fraudStatus,
            'midtrans_transaction_id' => $request->transaction_id,
            'va_number' => $request->va_numbers[0]['va_number'] ?? null,
            'settlement_time' => $request->settlement_time ?? null,
        ]);

        $payment->save();
        $booking->save();

        return response()->json(['message' => 'Callback processed'], 200);
    }
}
