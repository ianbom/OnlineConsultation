export default interface Payment {
  id: number;
  booking_id: number;
  amount: number;
  method: string;
  order_id: string;
  midtrans_transaction_id: string | null;
  payment_type: string | null;
  fraud_status: string | null;
  va_number: string | null;
  settlement_time: string | null; // ISO datetime or null
  snap_token: string | null;
  payment_url: string | null;
  status: string
  paid_at: string | null;
  expiry_time: string | null;
  created_at: string;
  updated_at: string;
}


