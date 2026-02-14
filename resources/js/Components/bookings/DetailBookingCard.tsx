import { Avatar, AvatarFallback, AvatarImage } from '@/Components/ui/avatar';
import { Booking } from '@/Interfaces';
import { format } from 'date-fns';
import { id as idLocale } from 'date-fns/locale';
import {
    Calendar,
    Clock,
    CreditCard,
    FileText,
    Hourglass,
    Star,
    Video,
} from 'lucide-react';

interface Props {
    booking: Booking;
}

export default function BookingDetailCard({ booking }: Props) {
    const photoUrl = booking.counselor.user.profile_pic
        ? `/storage/${booking.counselor.user.profile_pic}`
        : '/default-avatar.png';

    const sessionDate = new Date(booking.schedule.date);
    const startTime = booking.schedule.start_time.substring(0, 5);
    const endTime =
        booking.second_schedule?.end_time?.substring(0, 5) ||
        booking.schedule.end_time.substring(0, 5);

    const timeRange = `${startTime} - ${endTime}`;
    const total = booking.payment?.amount ?? 0;

    const formatCurrency = (amount: number) =>
        new Intl.NumberFormat('id-ID', {
            style: 'currency',
            currency: 'IDR',
            minimumFractionDigits: 0,
        }).format(amount);

    const formatPaymentType = (status: string) =>
        status
            .replace(/_/g, ' ')
            .split(' ')
            .map((w) => w.charAt(0).toUpperCase() + w.slice(1))
            .join(' ');

    const specializations = booking.counselor.specialization
        ?.split(',')
        .map((s: string) => s.trim())
        .filter(Boolean);

    return (
        <div className="overflow-hidden rounded-xl border border-slate-100 bg-white shadow-sm dark:border-slate-800 dark:bg-slate-900">
            {/* ===== COUNSELOR HEADER ===== */}
            <div className="border-b border-slate-100 bg-gradient-to-r from-white to-primary/5 p-6 dark:border-slate-800 dark:from-slate-900 dark:to-primary/10 sm:p-8">
                <div className="flex flex-col items-start gap-5 sm:flex-row sm:items-center">
                    {/* Avatar */}
                    <div className="relative">
                        <Avatar className="h-24 w-24 border-4 border-white shadow-md dark:border-slate-700">
                            <AvatarImage
                                src={photoUrl}
                                alt={booking.counselor.user.name}
                                className="object-cover"
                            />
                            <AvatarFallback className="text-xl font-semibold">
                                {booking.counselor.user.name
                                    .split(' ')
                                    .map((n) => n[0])
                                    .join('')}
                            </AvatarFallback>
                        </Avatar>
                        {booking.counselor.status === 'active' && (
                            <div
                                className="absolute bottom-1 right-1 h-5 w-5 rounded-full border-2 border-white bg-green-500 dark:border-slate-700"
                                title="Online"
                            />
                        )}
                    </div>

                    <div className="flex-1">
                        <h2 className="mb-1 text-xl font-bold text-slate-900 dark:text-white sm:text-2xl">
                            {booking.counselor.user.name}
                        </h2>
                        <p className="mb-3 text-sm text-slate-500 dark:text-slate-400">
                            {booking.counselor.education}
                        </p>

                        {/* Specialization Badges */}
                        {specializations && specializations.length > 0 && (
                            <div className="mb-3 flex flex-wrap gap-2">
                                {specializations.map(
                                    (item: string, index: number) => (
                                        <span
                                            key={index}
                                            className="inline-flex items-center rounded-full border border-primary/20 bg-primary/10 px-3 py-1 text-xs font-medium text-primary"
                                        >
                                            {item}
                                        </span>
                                    ),
                                )}
                            </div>
                        )}

                        {/* Rating Display */}
                        {booking.rating && (
                            <div className="mt-2 flex items-center gap-2 border-t border-slate-200/60 pt-2 dark:border-slate-700/60">
                                <div className="flex text-yellow-400">
                                    {[1, 2, 3, 4, 5].map((star) => (
                                        <Star
                                            key={star}
                                            className={`h-4 w-4 ${
                                                star <= booking.rating!.rating
                                                    ? 'fill-yellow-400 text-yellow-400'
                                                    : 'text-slate-300'
                                            }`}
                                        />
                                    ))}
                                </div>
                                <span className="text-sm font-semibold text-slate-700 dark:text-slate-200">
                                    {booking.rating.rating}.0
                                </span>
                                {booking.rating.commentar && (
                                    <span className="ml-1 text-xs italic text-slate-500">
                                        "
                                        {booking.rating.commentar.substring(
                                            0,
                                            40,
                                        )}
                                        {booking.rating.commentar.length > 40
                                            ? '...'
                                            : ''}
                                        "
                                    </span>
                                )}
                            </div>
                        )}
                    </div>
                </div>
            </div>

            {/* ===== APPOINTMENT DETAILS ===== */}
            <div className="p-6 sm:p-8">
                <h3 className="mb-6 text-lg font-semibold text-slate-900 dark:text-white">
                    Detail Jadwal
                </h3>

                <div className="space-y-5">
                    {/* Date */}
                    <DetailRow
                        icon={<Calendar className="h-5 w-5" />}
                        label="Tanggal"
                        value={format(sessionDate, 'EEEE, d MMMM yyyy', {
                            locale: idLocale,
                        })}
                    />

                    {/* Time & Duration side by side */}
                    <div className="flex flex-col gap-5 sm:flex-row">
                        <div className="flex-1">
                            <DetailRow
                                icon={<Clock className="h-5 w-5" />}
                                label="Waktu"
                                value={`${timeRange} WIB`}
                            />
                        </div>
                        <div className="flex-1">
                            <DetailRow
                                icon={<Hourglass className="h-5 w-5" />}
                                label="Durasi"
                                value={`${booking.duration_hours} Jam`}
                            />
                        </div>
                    </div>

                    <div className="flex flex-col gap-5 sm:flex-row">
                        {/* Consultation Type */}
                        <div className="flex-1">
                            <DetailRow
                                icon={<Video className="h-5 w-5" />}
                                label="Jenis Konsultasi"
                                value={
                                    booking.consultation_type === 'online'
                                        ? 'Online'
                                        : 'Tatap Muka'
                                }
                                badge={
                                    booking.consultation_type === 'online' &&
                                    booking.meeting_link
                                        ? {
                                              text: 'Link Ready',
                                              variant: 'green' as const,
                                          }
                                        : booking.consultation_type ===
                                                'online' &&
                                            booking.link_status === 'pending'
                                          ? {
                                                text: 'Menunggu Link',
                                                variant: 'yellow' as const,
                                            }
                                          : undefined
                                }
                            />
                        </div>
                        <div className="flex-1">
                            {/* Payment Method */}
                            <DetailRow
                                icon={<CreditCard className="h-5 w-5" />}
                                label="Metode Pembayaran"
                                value={formatPaymentType(
                                    booking.payment?.payment_type ?? 'Belum',
                                )}
                                badge={
                                    booking.payment?.status === 'success'
                                        ? {
                                              text: 'Paid',
                                              variant: 'green' as const,
                                          }
                                        : booking.payment?.status === 'pending'
                                          ? {
                                                text: 'Pending',
                                                variant: 'yellow' as const,
                                            }
                                          : undefined
                                }
                                isLast
                            />
                        </div>
                    </div>
                </div>
            </div>

            {/* ===== NOTES SECTION ===== */}
            <div className="space-y-4 px-6 pb-6 sm:px-8 sm:pb-8">
                {/* Client Notes */}
                {booking.notes && (
                    <div className="rounded-lg border border-slate-100 bg-slate-50 p-5 dark:border-slate-700 dark:bg-slate-800">
                        <div className="mb-3 flex items-center gap-2">
                            <FileText className="h-4 w-4 text-slate-400" />
                            <h4 className="text-sm font-semibold uppercase tracking-wider text-slate-900 dark:text-white">
                                Catatan Klien
                            </h4>
                        </div>
                        <p className="text-sm leading-relaxed text-slate-600 dark:text-slate-300">
                            {booking.notes}
                        </p>
                    </div>
                )}

                {/* Counselor Notes */}
                {booking.counselor_notes && (
                    <div className="rounded-lg border border-amber-100 bg-amber-50 p-5 dark:border-amber-900/30 dark:bg-amber-900/10">
                        <div className="mb-3 flex items-center gap-2">
                            <FileText className="h-4 w-4 text-amber-600/70 dark:text-amber-400" />
                            <h4 className="text-sm font-semibold uppercase tracking-wider text-amber-900 dark:text-amber-100">
                                Catatan Konselor
                            </h4>
                        </div>
                        <p className="text-sm font-medium leading-relaxed text-amber-900/80 dark:text-amber-100/80">
                            {booking.counselor_notes}
                        </p>
                    </div>
                )}
            </div>

            {/* ===== PRICING FOOTER ===== */}
            <div className="border-t border-slate-100 bg-slate-50 p-6 dark:border-slate-800 dark:bg-slate-800/50">
                <div className="flex flex-col gap-3">
                    <div className="flex justify-between text-sm text-slate-500 dark:text-slate-400">
                        <span>Biaya Sesi Konseling</span>
                        <span>{formatCurrency(booking.price)}</span>
                    </div>
                    <div className="my-1 h-px bg-slate-200 dark:bg-slate-700" />
                    <div className="flex items-center justify-between">
                        <span className="font-semibold text-slate-900 dark:text-white">
                            Total
                        </span>
                        <span className="text-xl font-bold text-primary">
                            {formatCurrency(total)}
                        </span>
                    </div>
                </div>
            </div>
        </div>
    );
}

// ===== DETAIL ROW SUB-COMPONENT =====

interface DetailRowProps {
    icon: React.ReactNode;
    label: string;
    value: string | number;
    badge?: {
        text: string;
        variant: 'green' | 'yellow';
    };
    isLast?: boolean;
}

function DetailRow({ icon, label, value, badge, isLast }: DetailRowProps) {
    return (
        <div className="group flex items-start">
            <div className="flex-shrink-0 rounded-lg bg-slate-50 p-2 transition-colors group-hover:bg-primary/10 dark:bg-slate-800">
                <span className="text-slate-400 transition-colors group-hover:text-primary">
                    {icon}
                </span>
            </div>
            <div
                className={`ml-4 flex-1 ${!isLast ? 'border-b border-slate-100 pb-5 dark:border-slate-800' : 'pb-2'}`}
            >
                <p className="text-sm font-medium text-slate-500 dark:text-slate-400">
                    {label}
                </p>
                <div className="mt-1 flex items-center gap-2">
                    <p className="text-base font-semibold text-slate-900 dark:text-white">
                        {value}
                    </p>
                    {badge && (
                        <span
                            className={`inline-flex items-center rounded px-2 py-0.5 text-xs font-medium ${
                                badge.variant === 'green'
                                    ? 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300'
                                    : 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-300'
                            }`}
                        >
                            {badge.text}
                        </span>
                    )}
                </div>
            </div>
        </div>
    );
}
