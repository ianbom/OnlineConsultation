export default interface WorkDay {
  id: number;
  counselor_id: number;
  day_of_week: string; // 'monday', 'tuesday', etc.
  start_time: string; // HH:MM:SS
  end_time: string; // HH:MM:SS
  is_active: number;
  created_at: string;
  updated_at: string;
}
