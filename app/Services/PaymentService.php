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
            'order_id' => $orderId,
            'gross_amount' => $booking->price,
        ],
        'customer_details' => [
            'first_name' => $booking->client->name,
            'email' => $booking->client->email,
        ]
    ];

    $transaction = Snap::createTransaction($params);

    $snapToken = $transaction->token;
    $paymentUrl = $transaction->redirect_url;

    $payment = Payment::create([
        'booking_id' => $booking->id,
        'amount'     => $booking->price,
        'method'     => 'bank_transfer',
        'order_id'   => $orderId,
        'snap_token' => $snapToken,
        'payment_url'=> $paymentUrl,
        'status'     => 'pending',
    ]);

    return $payment;
}

}
