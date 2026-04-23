import {
    CancelledStatus,
    CompletedStatus,
    DpPaidStatus,
    ExpiredStatus,
    PaidStatus,
    PendingPaymentStatus,
    RescheduledStatus,
} from '@/Components/bookings/BookingStatusComponents';
import BookingDetailCard from '@/Components/bookings/DetailBookingCard';
import RatingModal from '@/Components/bookings/RatingModal';
import { PageLayout } from '@/Components/layout/PageLayout';
import { Button } from '@/Components/ui/button';
import { useCountdown } from '@/hooks/useCountdown';
import { Booking } from '@/Interfaces';
import { generateBookingPdf } from '@/lib/pdf/bookingPdf';
import { formatCurrency, formatStatus } from '@/utils/booking';
import { Link, router } from '@inertiajs/react';
import { format } from 'date-fns';
import { id as idLocale } from 'date-fns/locale';
import {
    ArrowLeft,
    Calendar,
    Headphones,
    MessageCircle,
    Printer,
    Star,
    Video,
    XCircle,
} from 'lucide-react';

interface Props {
    booking: Booking;
}

export default function BookingDetail({ booking }: Props) {
    const expiryTime = booking.payment?.expiry_time
        ? new Date(booking.payment.expiry_time)
        : null;
    const timeLeft = useCountdown(expiryTime);

    const getWhatsAppMessage = () => {
        const counselorName = booking.counselor.user.name;
        const scheduleDate = format(
            new Date(booking.schedule.date),
            'EEEE, d MMMM yyyy',
            { locale: idLocale },
        );
        const scheduleTime = `${booking.schedule.start_time.slice(0, 5)} - ${booking.schedule.end_time.slice(0, 5)}`;
        const consultationType =
            booking.consultation_type === 'online' ? 'Online' : 'Tatap Muka';
        const bookingCode = `#${booking.id}`;

        switch (booking.status) {
            case 'paid':
                return `Halo Kak ${counselorName}, 👋

Saya ingin konfirmasi jadwal konseling saya:

📋 *Detail Booking*
• Kode Booking: ${bookingCode}
• Tanggal: ${scheduleDate}
• Waktu: ${scheduleTime} WIB
• Tipe: ${consultationType}

Mohon informasi lebih lanjut untuk persiapan sesi konseling. Terima kasih! 🙏`;

            case 'rescheduled':
                return `Halo Kak ${counselorName}, 👋

Saya ingin mengkonfirmasi jadwal konseling saya yang telah di-reschedule:

📋 *Detail Booking*
• Kode Booking: ${bookingCode}
• Jadwal Baru: ${scheduleDate}
• Waktu: ${scheduleTime} WIB
• Tipe: ${consultationType}

Mohon konfirmasi apakah jadwal baru ini sudah sesuai. Terima kasih! 🙏`;

            default:
                if (
                    booking.refund_status === 'requested' ||
                    booking.refund_status === 'processed'
                ) {
                    return `Halo Admin, 👋

Saya ingin menanyakan status refund untuk booking saya:

📋 *Detail Booking*
• Kode Booking: ${bookingCode}
• Konselor: ${counselorName}
• Tanggal Booking: ${scheduleDate}
• Status Refund: ${booking.refund_status === 'requested' ? 'Diminta' : 'Diproses'}

Mohon informasi terkait proses refund saya. Terima kasih! 🙏`;
                }
                return '';
        }
    };

    const handleWhatsAppClick = () => {
        const message = getWhatsAppMessage();
        const phone = '6281913811966';
        const cleanPhone = phone.replace(/\D/g, '').replace(/^0/, '62');
        const waUrl = `https://wa.me/${cleanPhone}?text=${encodeURIComponent(message)}`;
        window.open(waUrl, '_blank');
    };

    const showWhatsAppButton =
        ['paid', 'dp_paid', 'rescheduled'].includes(booking.status) ||
        ['requested', 'processed'].includes(booking.refund_status);

    const renderStatusComponent = () => {
        if (booking.is_expired) {
            return <ExpiredStatus booking={booking} />;
        }

        if (booking.status === 'cancelled') {
            return <CancelledStatus booking={booking} />;
        }

        switch (booking.status) {
            case 'pending_payment':
                return <PendingPaymentStatus booking={booking} />;
            case 'paid':
                return <PaidStatus booking={booking} />;
            case 'dp_paid':
                return <DpPaidStatus booking={booking} />;
            case 'completed':
                return <CompletedStatus booking={booking} />;
            case 'rescheduled':
                return <RescheduledStatus booking={booking} />;
            default:
                return null;
        }
    };

    const handleCancelBooking = () => {
        if (!confirm('Anda yakin ingin membatalkan booking ini?')) return;

        router.post(
            route('client.cancel.booking', booking.id),
            {
                reason: 'Dibatalkan oleh client',
            },
            {
                preserveScroll: true,
            },
        );
    };

    const handlePrintBooking = async () => {
        await generateBookingPdf(booking, formatCurrency, formatStatus);
    };

    return (
        <PageLayout>
            <div className="mx-auto w-full max-w-7xl px-4 sm:px-6 lg:px-8">
                {/* ===== HEADER ===== */}
                <div className="mb-8 flex items-center gap-4">
                    <Link
                        href={route('client.booking.history')}
                        className="group rounded-full border border-slate-200 bg-white p-2 shadow-sm transition-all hover:border-primary hover:text-primary dark:border-slate-700 dark:bg-slate-900 dark:text-slate-300"
                    >
                        <ArrowLeft className="h-5 w-5 transition-transform group-hover:-translate-x-0.5" />
                    </Link>
                    <div>
                        <h1 className="text-2xl font-bold text-slate-900 dark:text-white">
                            Detail Booking
                        </h1>
                        <p className="text-sm text-slate-500 dark:text-slate-400">
                            Lihat dan kelola detail jadwal konsultasi Anda
                        </p>
                    </div>
                </div>

                {/* ===== 3-COLUMN GRID ===== */}
                <div className="grid grid-cols-1 gap-8 lg:grid-cols-3">
                    {/* LEFT: 2 columns - Booking Detail Card */}
                    <div className="space-y-6 lg:col-span-2">
                        <BookingDetailCard booking={booking} />
                    </div>

                    {/* RIGHT: 1 column - Sidebar */}
                    <div className="space-y-6 lg:col-span-1">
                        {/* Status & Actions Card */}
                        <div className="sticky top-24 space-y-6">
                            <div className="rounded-xl border border-slate-100 bg-white p-6 shadow-sm dark:border-slate-800 dark:bg-slate-900">
                                <h3 className="mb-4 text-lg font-semibold text-slate-900 dark:text-white">
                                    Status Booking
                                </h3>

                                {/* Status Component */}
                                <div className="mb-5">
                                    {renderStatusComponent()}
                                </div>

                                {/* Countdown Payment Expiry */}
                                {timeLeft &&
                                    !booking.is_expired &&
                                    booking.status === 'pending_payment' && (
                                        <div className="mb-4 rounded-md border border-red-200 bg-red-50 px-3 py-2 text-center text-sm font-medium text-red-600">
                                            {timeLeft === 'Kadaluarsa'
                                                ? 'Kadaluarsa'
                                                : `Sisa waktu: ${timeLeft}`}
                                        </div>
                                    )}

                                {/* Primary CTA - Join Meeting (full width) */}
                                {booking.meeting_link &&
                                    ['paid', 'rescheduled'].includes(
                                        booking.status,
                                    ) && (
                                        <div className="mb-4">
                                            <Button
                                                className="w-full gap-2 bg-primary shadow-lg shadow-primary/30 transition-all hover:scale-[1.02] hover:bg-primary/90 active:scale-[0.98]"
                                                asChild
                                            >
                                                <a
                                                    href={booking.meeting_link}
                                                    target="_blank"
                                                    rel="noopener noreferrer"
                                                >
                                                    <Video className="h-4 w-4" />
                                                    Masuk Sesi Konsultasi
                                                </a>
                                            </Button>
                                        </div>
                                    )}

                                {/* Action Buttons - 2 Column Grid */}
                                <div className="grid grid-cols-2 gap-3">
                                    {/* Reschedule */}
                                    {['paid', 'dp_paid', 'rescheduled'].includes(
                                        booking.status,
                                    ) &&
                                        !booking.is_expired &&
                                        booking.reschedule_status ===
                                            'none' && (
                                            <Link
                                                href={route(
                                                    'client.pick.reschedule',
                                                    booking.id,
                                                )}
                                                className="flex aspect-square flex-col items-center justify-center gap-2 rounded-xl border border-slate-200 bg-slate-50 p-4 text-slate-700 transition-all hover:border-primary hover:bg-primary/5 hover:text-primary dark:border-slate-700 dark:bg-slate-800 dark:text-slate-300 dark:hover:border-primary dark:hover:bg-primary/10"
                                            >
                                                <Calendar className="h-6 w-6" />
                                                <span className="text-center text-xs font-medium">
                                                    Reschedule
                                                </span>
                                            </Link>
                                        )}

                                    {/* Cancel Booking */}
                                    {['paid', 'dp_paid', 'rescheduled'].includes(
                                        booking.status,
                                    ) &&
                                        !booking.is_expired && (
                                            <button
                                                onClick={() =>
                                                    handleCancelBooking()
                                                }
                                                className="flex aspect-square flex-col items-center justify-center gap-2 rounded-xl border border-slate-200 bg-slate-50 p-4 text-rose-500 transition-all hover:border-rose-300 hover:bg-rose-50 dark:border-slate-700 dark:bg-slate-800 dark:hover:border-rose-500/50 dark:hover:bg-rose-900/20"
                                            >
                                                <XCircle className="h-6 w-6" />
                                                <span className="text-center text-xs font-medium">
                                                    Batalkan
                                                </span>
                                            </button>
                                        )}

                                    {/* Print Booking */}
                                    {['paid', 'completed'].includes(
                                        booking.status,
                                    ) && (
                                        <button
                                            onClick={() => handlePrintBooking()}
                                            className="flex aspect-square flex-col items-center justify-center gap-2 rounded-xl border border-slate-200 bg-slate-50 p-4 text-slate-700 transition-all hover:border-primary hover:bg-primary/5 hover:text-primary dark:border-slate-700 dark:bg-slate-800 dark:text-slate-300 dark:hover:border-primary dark:hover:bg-primary/10"
                                        >
                                            <Printer className="h-6 w-6" />
                                            <span className="text-center text-xs font-medium">
                                                Print
                                            </span>
                                        </button>
                                    )}

                                    {/* WhatsApp */}
                                    {showWhatsAppButton && (
                                        <button
                                            onClick={handleWhatsAppClick}
                                            className="flex aspect-square flex-col items-center justify-center gap-2 rounded-xl border border-green-200 bg-green-50 p-4 text-green-600 transition-all hover:border-green-400 hover:bg-green-100 dark:border-green-900/50 dark:bg-green-900/20 dark:text-green-400 dark:hover:border-green-700 dark:hover:bg-green-900/30"
                                        >
                                            <MessageCircle className="h-6 w-6" />
                                            <span className="text-center text-xs font-medium">
                                                {booking.refund_status !==
                                                'none'
                                                    ? 'Hubungi Admin'
                                                    : 'Hubungi Konselor'}
                                            </span>
                                        </button>
                                    )}
                                    {/* Rating - Square tile in grid */}
                                    {booking.status === 'completed' && (
                                        <RatingModal booking={booking} />
                                    )}
                                </div>

                                {/* Rating Display (if exists) */}
                                {booking.status === 'completed' &&
                                    booking.rating && (
                                        <div className="mt-3 rounded-lg border border-yellow-200 bg-yellow-50 p-3 dark:border-yellow-900/40 dark:bg-yellow-900/10">
                                            <div className="mb-1.5 flex items-center gap-1">
                                                {[1, 2, 3, 4, 5].map((star) => (
                                                    <Star
                                                        key={star}
                                                        className={`h-4 w-4 ${
                                                            star <=
                                                            booking.rating!
                                                                .rating
                                                                ? 'fill-yellow-400 text-yellow-400'
                                                                : 'text-slate-300'
                                                        }`}
                                                    />
                                                ))}
                                            </div>
                                            {booking.rating.commentar && (
                                                <p className="text-xs text-slate-600 dark:text-slate-400">
                                                    {booking.rating.commentar}
                                                </p>
                                            )}
                                        </div>
                                    )}

                                {/* Need Help */}
                                <div className="mt-6 border-t border-slate-100 pt-5 dark:border-slate-800">
                                    <h4 className="mb-1 text-sm font-semibold text-slate-900 dark:text-white">
                                        Butuh Bantuan?
                                    </h4>
                                    <p className="mb-3 text-xs text-slate-500">
                                        Jika Anda mengalami kesulitan atau
                                        membutuhkan bantuan.
                                    </p>
                                    <a
                                        href="https://wa.me/6281913811966"
                                        target="_blank"
                                        rel="noopener noreferrer"
                                        className="inline-flex items-center gap-2 text-sm font-medium text-primary transition-colors hover:text-primary/80"
                                    >
                                        <Headphones className="h-4 w-4" />
                                        Hubungi Support
                                    </a>
                                </div>
                            </div>

                            {/* Add to Calendar Card */}
                            <div className="relative hidden overflow-hidden rounded-xl bg-gradient-to-br from-indigo-500 to-primary p-6 text-white shadow-md lg:block">
                                <div className="relative z-10">
                                    <div className="mb-4 flex h-10 w-10 items-center justify-center rounded-lg bg-white/20 backdrop-blur-sm">
                                        <Calendar className="h-5 w-5 text-white" />
                                    </div>
                                    <h4 className="mb-1 text-lg font-bold">
                                        Lihat Semua Booking
                                    </h4>
                                    <p className="mb-4 text-sm text-indigo-100">
                                        Kelola jadwal konsultasi Anda.
                                    </p>
                                    <Button
                                        variant="secondary"
                                        className="bg-white text-indigo-600 shadow-sm hover:bg-indigo-50"
                                        asChild
                                    >
                                        <Link
                                            href={route(
                                                'client.booking.history',
                                            )}
                                        >
                                            Riwayat Booking
                                        </Link>
                                    </Button>
                                </div>
                                {/* Decorative circles */}
                                <div className="absolute -bottom-4 -right-4 h-24 w-24 rounded-full bg-white/10" />
                                <div className="absolute right-4 top-4 h-8 w-8 rounded-full bg-white/10" />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </PageLayout>
    );
}
