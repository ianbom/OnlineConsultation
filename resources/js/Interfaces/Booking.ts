export default interface Booking {
  id: number;
  client_id: number;
  counselor_id: number;
  schedule_id: number;
  previous_schedule_id: number | null;
  price: number;
  duration_hours: number;
  consultation_type: 'online' | 'offline';
  meeting_link: string | null;
  link_status: 'pending' | 'sent';
  status: 'pending_payment' | 'paid' | 'cancelled' | 'completed' | 'rescheduled';
  notes: string | null;
  created_at: string;
  updated_at: string;
}
