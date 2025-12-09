import {  Payment, Schedule, User } from '@/Interfaces';
import Counselor from "./Counselor";

export default interface Booking {
  id: number;
  client_id: number;
  counselor_id: number;
  schedule_id: number;
  previous_schedule_id: number | null;
  second_schedule_id: number | null;
  previous_second_schedule_id: number | null;
  price: number;
  duration_hours: number;
  consultation_type: 'online' | 'offline';
  meeting_link: string | null;
  link_status: 'pending' | 'sent';
  status: string;
  notes: string | null;
  counselor: Counselor;
  client: User;
  schedule: Schedule;
  second_schedule: Schedule;
  payment: Payment;
  created_at: string;
  updated_at: string;
}

