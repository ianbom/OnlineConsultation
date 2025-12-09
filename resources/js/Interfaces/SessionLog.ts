export default interface SessionLog {
  id: number;
  booking_id: number;
  counselor_notes: string | null;
  session_status: 'completed' | 'client_no_show' | 'rescheduled';
  created_at: string;
  updated_at: string;
}
