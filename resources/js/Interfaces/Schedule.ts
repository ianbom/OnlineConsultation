export default interface Schedule {
  id: number;
  workday_id: number;
  counselor_id: number;
  date: string;
  start_time: string;
  end_time: string;
  is_available: number;
  created_at: string;
  updated_at: string;
}
