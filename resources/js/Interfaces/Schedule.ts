export default interface Schedule {
  id: number;
  workday_id: number;
  counselor_id: number;
  date: string; // YYYY-MM-DD
  start_time: string; // HH:MM:SS
  end_time: string; // HH:MM:SS
  is_available: boolean;
  created_at: string;
  updated_at: string;
}
