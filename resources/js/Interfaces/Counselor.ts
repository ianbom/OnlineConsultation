import Schedule from './Schedule';
import User from './User';
import WorkDay from './WorkDay';

export default interface Counselor {
    id: number;
    user_id: number;
    education: string;
    specialization: string;
    description: string;
    price_per_session: number;
    status: string;
    created_at: string;
    updated_at: string;
    user: User;
    work_days: WorkDay[];
    schedules: Schedule[];
}
