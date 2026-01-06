import { PageLayout } from '@/Components/layout/PageLayout';
import { Badge } from '@/Components/ui/badge';
import { Button } from '@/Components/ui/button';
import { Card, CardContent, CardHeader, CardTitle } from '@/Components/ui/card';
import { Link, router } from '@inertiajs/react';
import { ChevronLeft, Printer } from 'lucide-react';

import {
    CancelledStatus,
    CompletedStatus,
    ExpiredStatus,
    PaidStatus,
    PendingPaymentStatus,
    RescheduledStatus,
} from '@/Components/bookings/BookingStatusComponents';
import BookingDetailCard from '@/Components/bookings/DetailBookingCard';
import { Booking } from '@/Interfaces';
import { useEffect, useState } from 'react';

interface Props {
    booking: Booking;
}

export default function BookingDetail({ booking }: Props) {
    const baseUrl = import.meta.env.VITE_APP_URL;
    const photoUrl = booking.counselor.user.profile_pic
        ? `${baseUrl}/storage/${booking.counselor.user.profile_pic}`
        : '/default-avatar.png';

    // Badge status booking
    const getBookingStatusBadge = (status: string) => {
        const statusMap: Record<string, string> = {
            pending_payment: 'warning',
            paid: 'success',
            completed: 'default',
            cancelled: 'destructive',
            rescheduled: 'secondary',
        };
        return statusMap[status] || 'secondary';
    };

    const formatStatus = (status: string) => {
        return status
            .replace(/_/g, ' ')
            .split(' ')
            .map((word) => word.charAt(0).toUpperCase() + word.slice(1))
            .join(' ');
    };

    const formatCurrency = (amount: number) => {
        return new Intl.NumberFormat('id-ID', {
            style: 'currency',
            currency: 'IDR',
            minimumFractionDigits: 0,
        }).format(amount);
    };

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
        const { jsPDF } = await import('jspdf');
        const doc = new jsPDF();

        const pageWidth = doc.internal.pageSize.getWidth();
        const margin = 15;
        const contentWidth = pageWidth - margin * 2;
        let y = 15;

        // Colors
        const primaryColor: [number, number, number] = [128, 0, 32]; // Maroon Red
        const secondaryColor: [number, number, number] = [34, 197, 94]; // Green
        const grayColor: [number, number, number] = [107, 114, 128];
        const lightGray: [number, number, number] = [243, 244, 246];

        // Helper function to draw a section header
        const drawSectionHeader = (title: string, yPos: number): number => {
            doc.setFillColor(...primaryColor);
            doc.rect(margin, yPos, contentWidth, 8, 'F');
            doc.setFontSize(11);
            doc.setFont('helvetica', 'bold');
            doc.setTextColor(255, 255, 255);
            doc.text(title, margin + 4, yPos + 5.5);
            doc.setTextColor(0, 0, 0);
            return yPos + 12;
        };

        // Helper function to draw a row
        const drawRow = (
            label: string,
            value: string,
            yPos: number,
            isAlt: boolean = false,
        ): number => {
            if (isAlt) {
                doc.setFillColor(...lightGray);
                doc.rect(margin, yPos - 4, contentWidth, 7, 'F');
            }
            doc.setFontSize(10);
            doc.setFont('helvetica', 'bold');
            doc.setTextColor(...grayColor);
            doc.text(label, margin + 4, yPos);
            doc.setFont('helvetica', 'normal');
            doc.setTextColor(0, 0, 0);
            doc.text(value, margin + 55, yPos);
            return yPos + 7;
        };

        // ===== HEADER =====
        doc.setFillColor(...primaryColor);
        doc.rect(0, 0, pageWidth, 35, 'F');

        doc.setFontSize(18);
        doc.setFont('helvetica', 'bold');
        doc.setTextColor(255, 255, 255);
        doc.text('BUKTI BOOKING KONSULTASI', pageWidth / 2, 15, {
            align: 'center',
        });

        doc.setFontSize(10);
        doc.setFont('helvetica', 'normal');
        doc.text(`No. Booking: #${booking.id}`, pageWidth / 2, 24, {
            align: 'center',
        });

        // Status Badge
        const statusText = formatStatus(booking.status);
        const statusWidth = doc.getTextWidth(statusText) + 12;
        const statusX = (pageWidth - statusWidth) / 2;

        if (booking.status === 'paid' || booking.status === 'completed') {
            doc.setFillColor(...secondaryColor);
        } else if (booking.status === 'cancelled') {
            doc.setFillColor(239, 68, 68);
        } else {
            doc.setFillColor(251, 191, 36);
        }
        doc.roundedRect(statusX, 27, statusWidth, 6, 2, 2, 'F');
        doc.setFontSize(8);
        doc.setTextColor(255, 255, 255);
        doc.text(statusText.toUpperCase(), pageWidth / 2, 31, {
            align: 'center',
        });

        doc.setTextColor(0, 0, 0);
        y = 45;

        // ===== INFO BOOKING & JADWAL =====
        const colWidth = contentWidth / 2 - 3;

        // Left column - Info Klien
        let leftY = drawSectionHeader('DATA KLIEN', y);
        doc.setDrawColor(220, 220, 220);
        doc.rect(margin, leftY - 4, colWidth, 28, 'S');

        leftY = drawRow('Nama', booking.client.name, leftY, true);
        leftY = drawRow('Email', booking.client.email, leftY);
        leftY = drawRow('Telepon', booking.client.phone || '-', leftY, true);

        // Right column - Info Counselor
        const rightX = margin + colWidth + 6;
        let rightY = y;
        doc.setFillColor(...primaryColor);
        doc.rect(rightX, rightY, colWidth, 8, 'F');
        doc.setFontSize(11);
        doc.setFont('helvetica', 'bold');
        doc.setTextColor(255, 255, 255);
        doc.text('DATA COUNSELOR', rightX + 4, rightY + 5.5);
        doc.setTextColor(0, 0, 0);
        rightY += 12;

        doc.setDrawColor(220, 220, 220);
        doc.rect(rightX, rightY - 4, colWidth, 28, 'S');

        // Right column rows
        const drawRightRow = (
            label: string,
            value: string,
            yPos: number,
            isAlt: boolean = false,
        ): number => {
            if (isAlt) {
                doc.setFillColor(...lightGray);
                doc.rect(rightX, yPos - 4, colWidth, 7, 'F');
            }
            doc.setFontSize(10);
            doc.setFont('helvetica', 'bold');
            doc.setTextColor(...grayColor);
            doc.text(label, rightX + 4, yPos);
            doc.setFont('helvetica', 'normal');
            doc.setTextColor(0, 0, 0);
            const maxWidth = colWidth - 55;
            const truncatedValue =
                doc.getTextWidth(value) > maxWidth
                    ? value.substring(0, 20) + '...'
                    : value;
            doc.text(truncatedValue, rightX + 45, yPos);
            return yPos + 7;
        };

        rightY = drawRightRow(
            'Nama',
            booking.counselor.user.name,
            rightY,
            true,
        );
        rightY = drawRightRow(
            'Spesialisasi',
            booking.counselor.specialization,
            rightY,
        );
        rightY = drawRightRow(
            'Pendidikan',
            booking.counselor.education,
            rightY,
            true,
        );

        y = Math.max(leftY, rightY) + 10;

        // ===== DETAIL BOOKING =====
        y = drawSectionHeader('DETAIL JADWAL KONSULTASI', y);
        doc.setDrawColor(220, 220, 220);
        doc.rect(margin, y - 4, contentWidth, 35, 'S');

        const scheduleDate = new Date(booking.schedule.date).toLocaleDateString(
            'id-ID',
            {
                weekday: 'long',
                year: 'numeric',
                month: 'long',
                day: 'numeric',
            },
        );
        const startTime = booking.schedule.start_time.substring(0, 5);
        const endTime = booking.schedule.end_time.substring(0, 5);
        const consultationType =
            booking.consultation_type === 'online' ? 'Online' : 'Offline';

        y = drawRow('Tanggal', scheduleDate, y, true);
        y = drawRow('Waktu', `${startTime} - ${endTime} WIB`, y);
        y = drawRow('Durasi', `${booking.duration_hours} Jam`, y, true);
        y = drawRow('Tipe', consultationType, y);
        y = drawRow('Biaya', formatCurrency(booking.price), y, true);

        y += 10;

        // ===== DATA PEMBAYARAN =====
        if (booking.payment) {
            y = drawSectionHeader('INFORMASI PEMBAYARAN', y);

            const paymentRows = 4 + (booking.payment.paid_at ? 1 : 0);
            doc.setDrawColor(220, 220, 220);
            doc.rect(margin, y - 4, contentWidth, paymentRows * 7, 'S');

            const paymentStatus =
                booking.payment.status === 'paid'
                    ? '✓ LUNAS'
                    : booking.payment.status === 'pending'
                      ? '⏳ Menunggu Pembayaran'
                      : formatStatus(booking.payment.status);

            y = drawRow('Order ID', booking.payment.order_id, y, true);
            y = drawRow('Status', paymentStatus, y);

            if (booking.payment.payment_type) {
                y = drawRow(
                    'Metode',
                    booking.payment.payment_type.toUpperCase(),
                    y,
                    true,
                );
            }

            y = drawRow(
                'Total Bayar',
                formatCurrency(booking.payment.amount),
                y,
            );

            if (booking.payment.paid_at) {
                const paidAt = new Date(booking.payment.paid_at).toLocaleString(
                    'id-ID',
                );
                y = drawRow('Dibayar pada', paidAt, y, true);
            }

            y += 10;
        }

        // ===== CATATAN =====
        if (booking.notes) {
            y = drawSectionHeader('CATATAN', y);
            doc.setDrawColor(220, 220, 220);

            doc.setFontSize(10);
            doc.setFont('helvetica', 'normal');
            const splitNotes = doc.splitTextToSize(
                booking.notes,
                contentWidth - 8,
            );
            const notesHeight = splitNotes.length * 5 + 6;

            doc.rect(margin, y - 4, contentWidth, notesHeight, 'S');
            doc.text(splitNotes, margin + 4, y);
            y += notesHeight + 6;
        }

        // ===== FOOTER =====
        const footerY = doc.internal.pageSize.getHeight() - 20;

        // Gradient line effect
        doc.setDrawColor(...primaryColor);
        doc.setLineWidth(0.5);
        doc.line(margin, footerY - 5, pageWidth - margin, footerY - 5);

        doc.setFontSize(8);
        doc.setTextColor(...grayColor);
        doc.setFont('helvetica', 'italic');
        doc.text(
            `Dokumen ini dicetak secara otomatis pada ${new Date().toLocaleString('id-ID')}`,
            pageWidth / 2,
            footerY,
            { align: 'center' },
        );

        doc.setFont('helvetica', 'normal');
        doc.text(
            'Terima kasih telah menggunakan layanan kami',
            pageWidth / 2,
            footerY + 5,
            { align: 'center' },
        );

        // Save PDF
        doc.save(`bukti-booking-${booking.id}.pdf`);
    };

    const expiryTime = booking.payment?.expiry_time
        ? new Date(booking.payment.expiry_time)
        : null;

    const [timeLeft, setTimeLeft] = useState<string | null>(null);

    useEffect(() => {
        if (!expiryTime) return;

        const interval = setInterval(() => {
            const now = new Date().getTime();
            const diff = expiryTime.getTime() - now;

            if (diff <= 0) {
                setTimeLeft('Kadaluarsa');
                clearInterval(interval);
                return;
            }

            const hours = Math.floor(diff / (1000 * 60 * 60));
            const minutes = Math.floor((diff % (1000 * 60 * 60)) / (1000 * 60));
            const seconds = Math.floor((diff % (1000 * 60)) / 1000);

            setTimeLeft(`${hours}j ${minutes}m ${seconds}d`);
        }, 1000);

        return () => clearInterval(interval);
    }, [expiryTime]);

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
