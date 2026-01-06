import { Schedule } from '@/Interfaces';

/**
 * Format number to Indonesian Rupiah currency
 */
export const formatCurrency = (amount: number): string => {
    return new Intl.NumberFormat('id-ID', {
        style: 'currency',
        currency: 'IDR',
        minimumFractionDigits: 0,
    }).format(amount);
};

/**
 * Format status from snake_case to Title Case
 * e.g., 'pending_payment' -> 'Pending Payment'
 */
export const formatStatus = (status: string): string => {
    return status
        .replace(/_/g, ' ')
        .split(' ')
        .map((word) => word.charAt(0).toUpperCase() + word.slice(1))
        .join(' ');
};

/**
 * Format schedule date and time for display
 */
export const formatScheduleDateTime = (
    schedule: Schedule,
    secondSchedule?: Schedule | null,
): { date: string; time: string } => {
    const date = new Date(schedule.date);
    const formattedDate = date.toLocaleDateString('id-ID', {
        weekday: 'long',
        year: 'numeric',
        month: 'long',
        day: 'numeric',
    });

    const startTime = schedule.start_time.substring(0, 5);
    const endTime = secondSchedule
        ? secondSchedule.end_time.substring(0, 5)
        : schedule.end_time.substring(0, 5);

    return {
        date: formattedDate,
        time: `${startTime} - ${endTime}`,
    };
};

/**
 * Get profile picture URL with fallback to default avatar
 */
export const getProfilePicUrl = (profilePic: string | null): string => {
    const baseUrl = import.meta.env.VITE_APP_URL;
    return profilePic
        ? `${baseUrl}/storage/${profilePic}`
        : '/default-avatar.png';
};

/**
 * Status to badge variant mapping
 */
export const STATUS_BADGE_MAP: Record<string, string> = {
    pending_payment: 'warning',
    paid: 'success',
    completed: 'default',
    cancelled: 'destructive',
    rescheduled: 'secondary',
};

/**
 * Get badge variant for booking status
 */
export const getBookingStatusBadge = (status: string): string => {
    return STATUS_BADGE_MAP[status] || 'secondary';
};

/**
 * Tab value types for booking history
 */
export type BookingTabValue =
    | 'pending_payment'
    | 'paid'
    | 'completed'
    | 'cancelled'
    | 'rescheduled';

/**
 * Sort option types for booking history
 */
export type BookingSortOption =
    | 'date_asc'
    | 'date_desc'
    | 'name_asc'
    | 'name_desc';

/**
 * Map tab status to card status for BookingCard component
 */
export const mapTabStatusToCardStatus = (
    status: BookingTabValue,
): 'completed' | 'cancelled' | 'upcoming' | 'pending' => {
    switch (status) {
        case 'pending_payment':
            return 'pending';
        case 'paid':
        case 'rescheduled':
            return 'upcoming';
        case 'completed':
            return 'completed';
        case 'cancelled':
            return 'cancelled';
        default:
            return 'pending';
    }
};

/**
 * Get display status for a booking based on its actual status
 */
export const getBookingDisplayStatus = (
    bookingStatus: string,
): BookingTabValue => {
    switch (bookingStatus) {
        case 'pending_payment':
            return 'pending_payment';
        case 'paid':
            return 'paid';
        case 'completed':
            return 'completed';
        case 'cancelled':
            return 'cancelled';
        case 'rescheduled':
            return 'rescheduled';
        default:
            return 'pending_payment';
    }
};
