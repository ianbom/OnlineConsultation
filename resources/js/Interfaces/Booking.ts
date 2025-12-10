import { Payment, Schedule, User } from "@/Interfaces";
import Counselor from "./Counselor";

export default interface Booking {
  id: number;

  // foreign keys
  client_id: number;
  counselor_id: number;

  schedule_id: number;
  second_schedule_id: number | null;

  previous_schedule_id: number | null;
  previous_second_schedule_id: number | null;

  // booking data
  price: number;
  duration_hours: number;
  consultation_type: "online" | "offline";
  meeting_link: string | null;
  link_status: "pending" | "sent" | null;

  status:
    | "pending_payment"
    | "paid"
    | "cancelled"
    | "completed"
    | "rescheduled";

  notes: string | null;

  // cancelation & refund tracking
  cancelled_by: "client" | "counselor" | "admin" | "system" |null;
  cancel_reason: string | null;
  cancelled_at: string | null;

  refund_status: "none" | "requested" | "processed";
  refund_processed_at: string | null;

  is_expired: boolean;

  // relations
  client: User;
  counselor: Counselor;
  schedule: Schedule;
  second_schedule: Schedule | null;

  previous_schedule: Schedule | null;
  previous_second_schedule: Schedule | null;

  payment: Payment | null; // pendukung jika booking belum punya payment

  created_at: string;
  updated_at: string;
}
