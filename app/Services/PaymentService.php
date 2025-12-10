<?php

namespace App\Services;

use App\Models\Payment;
use Midtrans\Snap;
use Midtrans\Config;

class PaymentService
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        Config::$serverKey = config('midtrans.server_key');
        Config::$isProduction = false;
        Config::$isSanitized = true;
        Config::$is3ds = true;
    }

public function createPayment($booking)
{
    $orderId = "ORDER-" . time() . "-" . $booking->id;

    $params = [
        'transaction_details' => [
            'order_id'      => $orderId,
            'gross_amount'  => $booking->price,
        ],
        'customer_details' => [
            'first_name' => $booking->client->name,
            'email'      => $booking->client->email,
        ],

        'expiry' => [
            'start_time' => now()->format('Y-m-d H:i:s O'),
            'unit' => 'minutes',
            'duration' => 15
    ]
    ];

    // Request ke Midtrans
    $transaction = Snap::createTransaction($params);

    // Data Snap
    $snapToken  = $transaction->token;
    $paymentUrl = $transaction->redirect_url;

    // Hitung waktu expiry di aplikasi
    $expiryTime = now()->addMinutes(15);

    // Simpan ke table payments
    $payment = Payment::create([
        'booking_id'          => $booking->id,
        'amount'              => $booking->price,
        'method'              => null,
        'order_id'            => $orderId,
        'snap_token'          => $snapToken,
        'payment_url'         => $paymentUrl,
        'status'              => 'pending',
        'expiry_time'         => $expiryTime,  // <── INI YANG DITAMBAHKAN
    ]);

    return $payment;
}


}
