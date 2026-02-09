export default interface Payment {
    id: number;
    booking_id: number;
    amount: number;
    method: string | null;
    order_id: string;
    midtrans_transaction_id: string | null;
    payment_type: string | null;
    fraud_status: string | null;
    va_number: string | null;
    settlement_time: string | null;
    snap_token: string | null;
    payment_url: string | null;
    transaction_status: string | null;
    failure_reason: string | null;
    refund_amount: number | null;
    refund_reason: string | null;
    refund_time: string | null;
    status: 'pending' | 'success' | 'failed' | 'refund' | 'refunded';
    paid_at: string | null;
    expiry_time: string | null;
    created_at: string;
    updated_at: string;
}
