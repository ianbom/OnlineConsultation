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
import { ChevronLeft, Printer } from 'lucide-react';

interface Props {
    booking: Booking;
}

export default function BookingDetail({ booking }: Props) {
    const expiryTime = booking.payment?.expiry_time
        ? new Date(booking.payment.expiry_time)
        : null;
    const timeLeft = useCountdown(expiryTime);

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

                <div className="mb-6 flex items-center justify-between">
                    <div>
                        <h1 className="font-display text-2xl font-semibold text-foreground">
                            Detail Booking
                        </h1>
                    </div>

                    <div className="flex items-center gap-4">
                        {/* Status Badge */}
                        <Badge
                            variant={
                                getBookingStatusBadge(booking.status) as any
                            }
                            className="text-sm"
                        >
                            {formatStatus(booking.status)}
                        </Badge>

                        {/* Countdown Payment Expiry */}
                        {timeLeft &&
                            !booking.is_expired &&
                            booking.status == 'pending_payment' && (
                                <div className="rounded-md border border-red-200 bg-red-50 px-3 py-1 text-xs font-medium text-red-600">
                                    {timeLeft === 'Kadaluarsa'
                                        ? 'Kadaluarsa'
                                        : `Sisa waktu: ${timeLeft}`}
                                </div>
                            )}

                        {/* Cancel Button */}
                        {['paid', 'rescheduled'].includes(booking.status) &&
                            !booking.is_expired && (
                                <Button
                                    variant="destructive"
                                    size="sm"
                                    onClick={() => handleCancelBooking()}
                                >
                                    Cancel Booking
                                </Button>
                            )}

                        {/* Print Button */}
                        {['paid', 'completed'].includes(booking.status) && (
                            <Button
                                variant="outline"
                                size="sm"
                                onClick={() => handlePrintBooking()}
                                className="gap-1"
                            >
                                <Printer className="h-4 w-4" />
                                Print Bukti Booking
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
