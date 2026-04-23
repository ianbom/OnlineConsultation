import { Button } from '@/Components/ui/button';
import { Booking } from '@/Interfaces';
import { format } from 'date-fns';
import { id as idLocale } from 'date-fns/locale';
import {
    AlertCircle,
    ArrowDown,
    Calendar,
    CheckCircle2,
    Clock,
    ExternalLink,
    XCircle,
} from 'lucide-react';

interface StatusComponentProps {
    booking: Booking;
}

// Status: pending_payment
export function PendingPaymentStatus({ booking }: StatusComponentProps) {
    return (
        <div className="space-y-4">
            <div className="flex items-start gap-3 rounded-lg border border-amber-200 bg-amber-50 p-4 dark:border-amber-900/40 dark:bg-amber-900/10">
                <div className="rounded-lg bg-amber-100 p-1.5 dark:bg-amber-900/30">
                    <AlertCircle className="h-4 w-4 text-amber-600 dark:text-amber-400" />
                </div>
                <div className="min-w-0 flex-1">
                    <p className="font-semibold text-amber-900 dark:text-amber-100">
                        Menunggu Pembayaran
                    </p>
                    <p className="mt-0.5 text-xs text-amber-700/80 dark:text-amber-300/70">
                        Selesaikan pembayaran dalam waktu yang ditentukan
                    </p>
                </div>
            </div>

            <Button className="w-full" size="lg" variant="default" asChild>
                <a
                    href={booking.payment?.payment_url ?? ''}
                    target="_blank"
                    rel="noopener noreferrer"
                >
                    <ExternalLink className="mr-2 h-4 w-4" />
                    Bayar Sekarang
                </a>
            </Button>
        </div>
    );
}

// Status: paid (confirmed)
export function PaidStatus({ booking }: StatusComponentProps) {
    const now = new Date();
    const sessionDateTime = new Date(
        `${booking.schedule.date}T${booking.schedule.start_time}`,
    );
    const hoursUntilSession =
        (sessionDateTime.getTime() - now.getTime()) / (1000 * 60 * 60);
    const isTooCloseToSession = hoursUntilSession < 2 && hoursUntilSession > 0;
    const sessionDate = new Date(booking.schedule.date);
    const isPast = sessionDate < now;

    const statusLabel = (value: string) => {
        return value.charAt(0).toUpperCase() + value.slice(1);
    };

    return (
        <div className="space-y-3">
            {/* Payment Success */}
            <div className="flex items-center gap-3 rounded-lg border border-green-200 bg-green-50 p-3 dark:border-green-900/40 dark:bg-green-900/10">
                <div className="rounded-lg bg-green-100 p-1.5 dark:bg-green-900/30">
                    <CheckCircle2 className="h-4 w-4 text-green-600 dark:text-green-400" />
                </div>
                <p className="font-semibold text-green-800 dark:text-green-200">
                    Pembayaran Berhasil
                </p>
            </div>

            {/* Reschedule Info */}
            {booking.reschedule_status !== 'none' && (
                <div className="rounded-lg border border-slate-200 bg-slate-50 p-4 dark:border-slate-700 dark:bg-slate-800">
                    <div className="flex items-center justify-between">
                        <h4 className="text-sm font-semibold text-slate-900 dark:text-white">
                            Status Reschedule
                        </h4>
                        <span
                            className={`rounded-full px-2.5 py-0.5 text-xs font-semibold ${
                                booking.reschedule_status === 'pending'
                                    ? 'bg-yellow-100 text-yellow-800'
                                    : booking.reschedule_status === 'approved'
                                      ? 'bg-green-100 text-green-800'
                                      : booking.reschedule_status === 'rejected'
                                        ? 'bg-red-100 text-red-800'
                                        : 'bg-gray-100 text-gray-700'
                            }`}
                        >
                            {statusLabel(booking.reschedule_status ?? '')}
                        </span>
                    </div>

                    {/* {booking.reschedule_by && (
                        <p className="text-xs text-slate-500 dark:text-slate-400">
                            Diminta oleh:{' '}
                            <span className="font-medium text-slate-700 dark:text-slate-300">
                                {statusLabel(booking.reschedule_by)}
                            </span>
                        </p>
                    )}

                    {booking.reschedule_reason && (
                        <p className="mt-1 text-xs text-slate-500 dark:text-slate-400">
                            Alasan:{' '}
                            <span className="font-medium text-slate-700 dark:text-slate-300">
                                {booking.reschedule_reason}
                            </span>
                        </p>
                    )} */}
                </div>
            )}

            {/* Too close warning */}
            {isTooCloseToSession &&
                (booking.reschedule_status === 'none' ||
                    booking.reschedule_status === null) && (
                    <div className="flex items-center gap-2 rounded-lg border border-orange-200 bg-orange-50 p-3 dark:border-orange-900/40 dark:bg-orange-900/10">
                        <Clock className="h-4 w-4 flex-shrink-0 text-orange-500" />
                        <p className="text-xs text-orange-700 dark:text-orange-300">
                            Reschedule tidak tersedia (kurang dari 2 jam)
                        </p>
                    </div>
                )}

            {/* Meeting Link */}
            {booking.consultation_type === 'online' && (
                <>
                    {booking.meeting_link ? (
                        <div className="flex items-center gap-2 rounded-lg border border-primary/20 bg-primary/5 p-3">
                            <Calendar className="h-4 w-4 flex-shrink-0 text-primary" />
                            <p className="text-xs font-medium text-primary">
                                Link konsultasi tersedia
                            </p>
                        </div>
                    ) : (
                        !isPast && (
                            <div className="flex items-center gap-2 rounded-lg border border-slate-200 bg-slate-50 p-3 dark:border-slate-700 dark:bg-slate-800">
                                <Clock className="h-4 w-4 flex-shrink-0 text-slate-400" />
                                <p className="text-xs text-slate-500 dark:text-slate-400">
                                    Menunggu link meeting dari konselor
                                </p>
                            </div>
                        )
                    )}
                </>
            )}
        </div>
    );
}

export function DpPaidStatus({ booking }: StatusComponentProps) {
    return (
        <div className="space-y-4">
            <div className="flex items-start gap-3 rounded-lg border border-amber-200 bg-amber-50 p-4 dark:border-amber-900/40 dark:bg-amber-900/10">
                <div className="rounded-lg bg-amber-100 p-1.5 dark:bg-amber-900/30">
                    <AlertCircle className="h-4 w-4 text-amber-600 dark:text-amber-400" />
                </div>
                <div className="min-w-0 flex-1">
                    <p className="font-semibold text-amber-900 dark:text-amber-100">
                        DP Berhasil Dibayar
                    </p>
                    <p className="mt-0.5 text-xs text-amber-700/80 dark:text-amber-300/70">
                        Sisa pelunasan{' '}
                        {new Intl.NumberFormat('id-ID', {
                            style: 'currency',
                            currency: 'IDR',
                            minimumFractionDigits: 0,
                        }).format(booking.remaining_amount ?? 0)}{' '}
                        harus dikonfirmasi admin sebelum sesi offline dapat
                        dijalankan.
                    </p>
                </div>
            </div>
        </div>
    );
}

// Status: cancelled
export function CancelledStatus({ booking }: StatusComponentProps) {
    const cancelledBy =
        booking.cancelled_by === 'client'
            ? 'Anda'
            : booking.cancelled_by === 'counselor'
              ? 'Konselor'
              : booking.cancelled_by === 'admin'
                ? 'Admin'
                : 'Sistem';

    return (
        <div className="space-y-3">
            <div className="rounded-lg border border-red-200 bg-red-50 p-4 dark:border-red-900/40 dark:bg-red-900/10">
                <div className="mb-2 flex items-center gap-2">
                    <div className="rounded-lg bg-red-100 p-1.5 dark:bg-red-900/30">
                        <XCircle className="h-4 w-4 text-red-600 dark:text-red-400" />
                    </div>
                    <p className="font-semibold text-red-800 dark:text-red-200">
                        Booking Dibatalkan
                    </p>
                </div>
                <p className="text-xs text-red-700/80 dark:text-red-300/70">
                    Dibatalkan oleh {cancelledBy}
                </p>

                {/* {booking.cancel_reason && (
                    <p className="mt-2 rounded bg-white/60 p-2 text-xs italic text-red-700/70 dark:bg-black/10 dark:text-red-300/60">
                        "{booking.cancel_reason}"
                    </p>
                )} */}

                {booking.payment?.status === 'refund' && (
                    <p className="mt-2 text-xs font-medium text-blue-600 dark:text-blue-400">
                        Dana sedang dalam proses refund
                    </p>
                )}

                {booking.payment?.status === 'refunded' && (
                    <p className="mt-2 text-xs font-medium text-green-600 dark:text-green-400">
                        Dana telah dikembalikan
                    </p>
                )}
            </div>
        </div>
    );
}

export function ExpiredStatus(_props: StatusComponentProps) {
    return (
        <div className="space-y-3">
            <div className="rounded-lg border border-orange-200 bg-orange-50 p-4 dark:border-orange-900/40 dark:bg-orange-900/10">
                <div className="mb-1 flex items-center gap-2">
                    <div className="rounded-lg bg-orange-100 p-1.5 dark:bg-orange-900/30">
                        <Clock className="h-4 w-4 text-orange-600 dark:text-orange-400" />
                    </div>
                    <p className="font-semibold text-orange-800 dark:text-orange-200">
                        Pembayaran Kadaluarsa
                    </p>
                </div>
                <p className="text-xs text-orange-700/80 dark:text-orange-300/70">
                    Waktu pembayaran telah berakhir
                </p>

                {/* {booking.cancel_reason && (
                    <p className="mt-2 rounded bg-white/60 p-2 text-xs italic text-orange-700/70 dark:bg-black/10 dark:text-orange-300/60">
                        "{booking.cancel_reason}"
                    </p>
                )} */}
            </div>
        </div>
    );
}

// Status: completed
export function CompletedStatus({ booking }: StatusComponentProps) {
    return (
        <div className="space-y-3">
            <div className="flex items-center gap-3 rounded-lg border border-primary/20 bg-primary/5 p-3">
                <div className="rounded-lg bg-primary/10 p-1.5">
                    <CheckCircle2 className="h-4 w-4 text-primary" />
                </div>
                <div>
                    <p className="font-semibold text-primary">
                        Sesi Konsultasi Selesai
                    </p>
                    <p className="text-xs text-slate-500 dark:text-slate-400">
                        Terima kasih telah menggunakan layanan kami
                    </p>
                </div>
            </div>

            {booking.counselor_notes && (
                <div className="rounded-lg border border-amber-100 bg-amber-50 p-4 dark:border-amber-900/30 dark:bg-amber-900/10">
                    <p className="mb-1 text-xs font-semibold uppercase tracking-wider text-amber-800 dark:text-amber-200">
                        Catatan Konselor
                    </p>
                    <p className="whitespace-pre-line text-sm leading-relaxed text-amber-900/80 dark:text-amber-100/80">
                        {booking.counselor_notes}
                    </p>
                </div>
            )}
        </div>
    );
}

// Status: rescheduled
export function RescheduledStatus({ booking }: StatusComponentProps) {
    const previous = booking.previous_schedule;
    const previousSecond = booking.previous_second_schedule;

    const now = new Date();
    const newSessionDateTime = new Date(
        `${booking.schedule.date}T${booking.schedule.start_time}`,
    );
    const hoursUntilSession =
        (newSessionDateTime.getTime() - now.getTime()) / (1000 * 60 * 60);
    const isTooCloseToSession = hoursUntilSession < 2 && hoursUntilSession > 0;

    const formatScheduleDate = (dateStr: string) => {
        return format(new Date(dateStr), 'EEEE, d MMMM yyyy', {
            locale: idLocale,
        });
    };

    const formatTime = (timeStr: string) => {
        return timeStr.substring(0, 5);
    };

    return (
        <div className="space-y-3">
            {/* Rescheduled Alert */}
            <div className="rounded-lg border border-amber-200 bg-amber-50 p-4 dark:border-amber-900/40 dark:bg-amber-900/10">
                <div className="flex items-center gap-2">
                    <div className="rounded-lg bg-amber-100 p-1.5 dark:bg-amber-900/30">
                        <Calendar className="h-4 w-4 text-amber-600 dark:text-amber-400" />
                    </div>
                    <div>
                        <p className="font-semibold text-amber-800 dark:text-amber-200">
                            Jadwal Diubah
                        </p>
                        {booking.reschedule_status === 'pending' && (
                            <p className="text-xs text-amber-600/80 dark:text-amber-400/70">
                                Menunggu persetujuan admin
                            </p>
                        )}
                    </div>
                </div>

                {previous && (
                    <div className="mt-3 space-y-2">
                        {/* Previous Schedule */}
                        <div className="rounded-lg border border-slate-200/60 bg-white/60 p-3 dark:border-slate-700/50 dark:bg-slate-800/30">
                            <p className="mb-1.5 text-[10px] font-bold uppercase tracking-widest text-slate-400 dark:text-slate-500">
                                Jadwal Sebelumnya
                            </p>
                            <div className="flex items-center gap-2">
                                <Calendar className="h-3.5 w-3.5 flex-shrink-0 text-slate-400" />
                                <p className="text-xs font-medium text-slate-500 line-through dark:text-slate-400">
                                    {formatScheduleDate(previous.date)}
                                </p>
                            </div>
                            <div className="mt-1 flex items-center gap-2">
                                <Clock className="h-3.5 w-3.5 flex-shrink-0 text-slate-400" />
                                <p className="text-xs text-slate-500 line-through dark:text-slate-400">
                                    {formatTime(previous.start_time)} -{' '}
                                    {formatTime(previous.end_time)} WIB
                                    {previousSecond && (
                                        <>
                                            {' & '}
                                            {formatTime(
                                                previousSecond.start_time,
                                            )}{' '}
                                            -{' '}
                                            {formatTime(
                                                previousSecond.end_time,
                                            )}{' '}
                                            WIB
                                        </>
                                    )}
                                </p>
                            </div>
                        </div>

                        {/* Arrow */}
                        <div className="flex justify-center">
                            <ArrowDown className="h-4 w-4 text-amber-400" />
                        </div>

                        {/* New Schedule */}
                        <div className="rounded-lg border border-amber-200/60 bg-white/60 p-3 dark:border-amber-800/40 dark:bg-amber-900/10">
                            <p className="mb-1.5 text-[10px] font-bold uppercase tracking-widest text-amber-500 dark:text-amber-400">
                                Jadwal Baru
                            </p>
                            <div className="flex items-center gap-2">
                                <Calendar className="h-3.5 w-3.5 flex-shrink-0 text-amber-500" />
                                <p className="text-xs font-semibold text-amber-900 dark:text-amber-100">
                                    {formatScheduleDate(booking.schedule.date)}
                                </p>
                            </div>
                            <div className="mt-1 flex items-center gap-2">
                                <Clock className="h-3.5 w-3.5 flex-shrink-0 text-amber-500" />
                                <p className="text-xs font-medium text-amber-800 dark:text-amber-200">
                                    {formatTime(booking.schedule.start_time)} -{' '}
                                    {formatTime(booking.schedule.end_time)} WIB
                                    {booking.second_schedule && (
                                        <>
                                            {' & '}
                                            {formatTime(
                                                booking.second_schedule
                                                    .start_time,
                                            )}{' '}
                                            -{' '}
                                            {formatTime(
                                                booking.second_schedule
                                                    .end_time,
                                            )}{' '}
                                            WIB
                                        </>
                                    )}
                                </p>
                            </div>
                        </div>
                    </div>
                )}
            </div>

            {/* Too close warning */}
            {isTooCloseToSession && (
                <div className="flex items-center gap-2 rounded-lg border border-orange-200 bg-orange-50 p-3 dark:border-orange-900/40 dark:bg-orange-900/10">
                    <Clock className="h-4 w-4 flex-shrink-0 text-orange-500" />
                    <p className="text-xs text-orange-700 dark:text-orange-300">
                        Reschedule & pembatalan tidak tersedia (kurang dari 2
                        jam)
                    </p>
                </div>
            )}

            {/* Meeting Link */}
            {booking.meeting_link && (
                <Button className="w-full" size="lg" asChild>
                    <a
                        href={booking.meeting_link}
                        target="_blank"
                        rel="noopener noreferrer"
                    >
                        Masuk ke Sesi Konsultasi
                    </a>
                </Button>
            )}
        </div>
    );
}
