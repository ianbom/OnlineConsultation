import {
    CancelledStatus,
    CompletedStatus,
    ExpiredStatus,
    PaidStatus,
    PendingPaymentStatus,
    RescheduledStatus,
} from '@/Components/bookings/BookingStatusComponents';
import BookingDetailCard from '@/Components/bookings/DetailBookingCard';
import { PageLayout } from '@/Components/layout/PageLayout';
import { Badge } from '@/Components/ui/badge';
import { Button } from '@/Components/ui/button';
import { Card, CardContent, CardHeader, CardTitle } from '@/Components/ui/card';
import { useCountdown } from '@/hooks/useCountdown';
import { Booking } from '@/Interfaces';
import { generateBookingPdf } from '@/lib/pdf/bookingPdf';
import {
    formatCurrency,
    formatStatus,
    getBookingStatusBadge,
} from '@/utils/booking';
import { Link, router } from '@inertiajs/react';
import { format } from 'date-fns';
import { id as idLocale } from 'date-fns/locale';
import { ChevronLeft, MessageCircle, Printer } from 'lucide-react';

interface Props {
    booking: Booking;
}

export default function BookingDetail({ booking }: Props) {
    const expiryTime = booking.payment?.expiry_time
        ? new Date(booking.payment.expiry_time)
        : null;
    const timeLeft = useCountdown(expiryTime);

    console.log(expiryTime);
    console.log(timeLeft);

    // Generate WhatsApp message based on status
    const getWhatsAppMessage = () => {
        const counselorName = booking.counselor.user.name;
        const scheduleDate = format(
            new Date(booking.schedule.date),
            'EEEE, d MMMM yyyy',
            { locale: idLocale }
        );
        const scheduleTime = `${booking.schedule.start_time.slice(0, 5)} - ${booking.schedule.end_time.slice(0, 5)}`;
        const consultationType = booking.consultation_type === 'online' ? 'Online' : 'Tatap Muka';
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
                // For refund status
                if (booking.refund_status === 'requested' || booking.refund_status === 'processed') {
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

    // Check if WhatsApp button should be shown
    const showWhatsAppButton =
        ['paid', 'rescheduled'].includes(booking.status) ||
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
            <div className="mx-auto max-w-4xl px-4">
                <Button variant="ghost" asChild className="mb-4">
                    <Link href={route('client.booking.history')}>
                        <ChevronLeft className="mr-1 h-4 w-4" />
                        Kembali ke Daftar Booking
                    </Link>
                </Button>

                <div className="mb-6 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                    <div>
                        <h1 className="font-display text-xl font-semibold text-foreground sm:text-2xl">
                            Detail Booking
                        </h1>
                    </div>

                    <div className="flex flex-wrap items-center gap-2 sm:gap-3">
                        {/* Status Badge */}
                        <Badge
                            variant={
                                getBookingStatusBadge(booking.status) as any
                            }
                            className="text-xs sm:text-sm"
                        >
                            {formatStatus(booking.status)}
                        </Badge>

                        {/* Countdown Payment Expiry */}
                        {timeLeft &&
                            !booking.is_expired &&
                            booking.status == 'pending_payment' && (
                                <div className="rounded-md border border-red-200 bg-red-50 px-2 py-1 text-xs font-medium text-red-600">
                                    {timeLeft === 'Kadaluarsa'
                                        ? 'Kadaluarsa'
                                        : `Sisa: ${timeLeft}`}
                                </div>
                            )}

                        {/* Cancel Button */}
                        {['paid', 'rescheduled'].includes(booking.status) &&
                            !booking.is_expired && (
                                <Button
                                    variant="destructive"
                                    size="sm"
                                    onClick={() => handleCancelBooking()}
                                    className="text-xs sm:text-sm"
                                >
                                    <span className="sm:hidden">Batal</span>
                                    <span className="hidden sm:inline">Cancel Booking</span>
                                </Button>
                            )}

                        {/* Print Button - Icon only */}
                        {['paid', 'completed'].includes(booking.status) && (
                            <Button
                                variant="outline"
                                size="icon"
                                onClick={() => handlePrintBooking()}
                                title="Print Bukti Booking"
                            >
                                <Printer className="h-4 w-4" />
                            </Button>
                        )}
                    </div>
                </div>

                <div className="space-y-6">
                    <div className="grid grid-cols-1 gap-6 lg:grid-cols-2">
                        {/* LEFT: Booking Detail */}
                        <div>
                            <BookingDetailCard booking={booking} />
                        </div>

                        {/* RIGHT: Status Component */}
                        <div className="h-fit">
                            {renderStatusComponent()}

                            {booking.notes && (
                                <Card className="my-3">
                                    <CardHeader>
                                        <CardTitle className="text-lg">
                                            Catatan Klien
                                        </CardTitle>
                                    </CardHeader>
                                    <CardContent>
                                        <p className="text-muted-foreground">
                                            {booking.notes}
                                        </p>
                                    </CardContent>
                                </Card>
                            )}

                            {/* WhatsApp CTA Button */}
                            {showWhatsAppButton && (
                                <Button
                                    variant="default"
                                    className="my-2 w-full gap-2 bg-green-600 hover:bg-green-700"
                                    onClick={handleWhatsAppClick}
                                >
                                    <MessageCircle className="h-4 w-4" />
                                    {booking.refund_status !== 'none'
                                        ? 'Hubungi Admin via WhatsApp'
                                        : 'Hubungi Konselor via WhatsApp'}
                                </Button>
                            )}

                            <Button
                                variant="outline"
                                className="my-2 w-full border-primary bg-amber-50 transition hover:border-white hover:bg-primary hover:text-white"
                                asChild
                            >
                                <Link href={route('client.booking.history')}>
                                    Lihat Semua Booking
                                </Link>
                            </Button>
                        </div>
                    </div>
                </div>
            </div>
        </PageLayout>
    );
}
