import { Button } from '@/Components/ui/button';
import { Card, CardContent, CardHeader, CardTitle } from '@/Components/ui/card';
import { useToast } from '@/hooks/use-toast';
import { Booking } from '@/Interfaces';
import { Link } from '@inertiajs/react';
import {
    AlertCircle,
    Calendar,
    CheckCircle2,
    Clock,
    Copy,
    ExternalLink,
    XCircle,
} from 'lucide-react';
import { useState } from 'react';

interface StatusComponentProps {
    booking: Booking;
}

// Status: pending_payment
export function PendingPaymentStatus({ booking }: StatusComponentProps) {
    const { toast } = useToast();
    const [copied, setCopied] = useState(false);

    const handleCopyLink = () => {
        navigator.clipboard.writeText(booking.payment?.payment_url ?? '');
        setCopied(true);
        toast({
            title: 'Link disalin',
            description: 'Link pembayaran berhasil disalin ke clipboard',
        });
        setTimeout(() => setCopied(false), 2000);
    };

    return (
        <div className="space-y-4">
            {/* Alert Pembayaran Tertunda */}
            <Card className="border-warning/30 bg-warning/5">
                <CardContent className="p-4">
                    <div className="flex w-full items-start gap-3">
                        <AlertCircle className="mt-0.5 h-5 w-5 text-warning" />

                        <div className="min-w-0 flex-1">
                            {' '}
                            {/* mencegah overflow */}
                            <h4 className="mb-1 font-medium text-foreground">
                                Menunggu Pembayaran
                            </h4>
                            <p className="mb-3 break-words text-sm text-muted-foreground">
                                Silakan selesaikan pembayaran untuk
                                mengonfirmasi booking Anda. Booking akan
                                otomatis dibatalkan jika pembayaran tidak
                                diselesaikan dalam 15 menit.
                            </p>
                            {/* Link Pembayaran */}
                            <div className="mb-3 flex w-full items-center gap-2">
                                <div className="max-w-full flex-1 overflow-hidden truncate rounded-lg bg-background p-3 font-mono text-sm text-muted-foreground">
                                    {booking.payment?.payment_url}
                                </div>

                                <Button
                                    variant="outline"
                                    size="icon"
                                    onClick={handleCopyLink}
                                >
                                    {copied ? (
                                        <CheckCircle2 className="h-4 w-4 text-success" />
                                    ) : (
                                        <Copy className="h-4 w-4" />
                                    )}
                                </Button>

                                <Button variant="outline" size="icon" asChild>
                                    <a
                                        href={
                                            booking.payment?.payment_url ?? ''
                                        }
                                        target="_blank"
                                        rel="noopener noreferrer"
                                    >
                                        <ExternalLink className="h-4 w-4" />
                                    </a>
                                </Button>
                            </div>
                        </div>
                    </div>
                </CardContent>
            </Card>

            {/* Tombol Aksi */}
            <div className="space-y-2">
                <Button className="w-full" size="lg" variant="default" asChild>
                    <a
                        href={booking.payment?.payment_url ?? ''}
                        target="_blank"
                        rel="noopener noreferrer"
                    >
                        Bayar Sekarang
                    </a>
                </Button>
                {/* <Button className="w-full" size="lg" variant="outline" asChild>
          <Link href={route("client.payment.check", booking.id)}>
            Cek Status Pembayaran
          </Link>
        </Button> */}
            </div>
        </div>
    );
}

// Status: paid (confirmed)
export function PaidStatus({ booking }: StatusComponentProps) {
    const sessionDate = new Date(booking.schedule.date);
    const now = new Date();
    const isPast = sessionDate < now;

    // Kombinasikan tanggal dan waktu untuk mendapatkan datetime lengkap
    const sessionDateTime = new Date(
        `${booking.schedule.date}T${booking.schedule.start_time}`,
    );

    // Hitung selisih waktu dalam jam
    const hoursUntilSession =
        (sessionDateTime.getTime() - now.getTime()) / (1000 * 60 * 60);
    const isTooCloseToSession = hoursUntilSession < 2 && hoursUntilSession > 0;

    const showRescheduleButton =
        booking.status === 'paid' &&
        !booking.is_expired &&
        booking.reschedule_status === 'none' &&
        hoursUntilSession >= 2; // Hanya tampilkan jika masih >= 2 jam

    const statusLabel = (value: string) => {
        return value.charAt(0).toUpperCase() + value.slice(1);
    };

    return (
        <div className="space-y-4">
            {/* Alert Pembayaran Berhasil */}
            <Card className="border-success/30 bg-success/5">
                <CardContent className="p-4">
                    <div className="flex items-start gap-3">
                        <CheckCircle2 className="mt-0.5 h-5 w-5 text-success" />
                        <div className="flex-1">
                            <h4 className="mb-1 font-medium text-foreground">
                                Pembayaran Berhasil
                            </h4>
                            <p className="text-sm text-muted-foreground">
                                Booking Anda telah dikonfirmasi. Silahkan datang
                                sesuai jadwal yang telah dipesan.
                            </p>
                        </div>
                    </div>
                </CardContent>
            </Card>

            {/* =============================== */}
            {/* BLOK RESCHEDULE INFORMATION     */}
            {/* =============================== */}

            {booking.reschedule_status !== 'none' && (
                <Card className="border-primary/20 bg-primary/5">
                    <CardContent className="space-y-3 p-4">
                        <h4 className="font-semibold text-foreground">
                            Status Reschedule
                        </h4>

                        {/* STATUS BADGE */}
                        <div className="flex justify-between">
                            <span className="text-muted-foreground">
                                Status
                            </span>
                            <span
                                className={`rounded-full px-3 py-1 text-xs font-semibold ${
                                    booking.reschedule_status === 'pending'
                                        ? 'bg-yellow-100 text-yellow-800'
                                        : booking.reschedule_status ===
                                            'approved'
                                          ? 'bg-green-100 text-green-800'
                                          : booking.reschedule_status ===
                                              'rejected'
                                            ? 'bg-red-100 text-red-800'
                                            : 'bg-gray-100 text-gray-700'
                                }`}
                            >
                                {statusLabel(booking.reschedule_status ?? '')}
                            </span>
                        </div>

                        {/* REQUESTED BY */}
                        <div className="flex justify-between">
                            <span className="text-muted-foreground">
                                Diminta oleh
                            </span>
                            <span className="font-medium">
                                {booking.reschedule_by
                                    ? statusLabel(booking.reschedule_by)
                                    : '-'}
                            </span>
                        </div>

                        {/* REASON */}
                        {booking.reschedule_reason && (
                            <div>
                                <span className="text-sm text-muted-foreground">
                                    Alasan Reschedule
                                </span>
                                <p className="mt-1 text-sm font-medium">
                                    {booking.reschedule_reason}
                                </p>
                            </div>
                        )}

                        {/* UI TAMBAHAN BERDASARKAN STATUS */}
                        {booking.reschedule_status === 'pending' && (
                            <div className="rounded-md border border-yellow-200 bg-yellow-50 p-3 text-xs text-yellow-700">
                                Permintaan reschedule sedang menunggu
                                persetujuan konselor.
                            </div>
                        )}

                        {booking.reschedule_status === 'approved' && (
                            <div className="rounded-md border border-green-200 bg-green-50 p-3 text-xs text-green-700">
                                Reschedule disetujui. Silakan cek jadwal terbaru
                                Anda.
                            </div>
                        )}

                        {booking.reschedule_status === 'rejected' && (
                            <div className="rounded-md border border-red-200 bg-red-50 p-3 text-xs text-red-700">
                                Reschedule ditolak. Jadwal tetap menggunakan
                                sesi sebelumnya.
                            </div>
                        )}
                    </CardContent>
                </Card>
            )}

            {/* =============================== */}
            {/* RESCHEDULE BUTTON               */}
            {/* =============================== */}
            {/* Peringatan jika terlalu dekat dengan sesi */}
            {isTooCloseToSession && booking.reschedule_status === 'none' && (
                <Card className="border-orange-300 bg-orange-50">
                    <CardContent className="p-4">
                        <div className="flex items-start gap-3">
                            <Clock className="mt-0.5 h-5 w-5 text-orange-600" />
                            <div className="flex-1">
                                <h4 className="mb-1 font-medium text-foreground">
                                    Reschedule Tidak Tersedia
                                </h4>
                                <p className="text-sm text-muted-foreground">
                                    Reschedule hanya dapat dilakukan minimal 2
                                    jam sebelum sesi dimulai. Silakan hubungi
                                    konselor jika ada kendala.
                                </p>
                            </div>
                        </div>
                    </CardContent>
                </Card>
            )}

            {showRescheduleButton && (
                <Card className="border-primary/20 bg-primary/5">
                    <CardContent className="pt-6">
                        <div className="flex items-start gap-4">
                            <div className="rounded-full bg-primary/10 p-3">
                                <Calendar className="h-6 w-6 text-primary" />
                            </div>
                            <div className="flex-1">
                                <h3 className="mb-1 text-lg font-semibold">
                                    Perlu Mengubah Jadwal?
                                </h3>
                                <p className="mb-4 text-sm text-muted-foreground">
                                    Anda dapat melakukan reschedule sesi
                                    konseling ini jika ada perubahan jadwal.
                                    Reschedule hanya dapat dilakukan minimal 2
                                    jam sebelum sesi.
                                </p>
                                <Button asChild>
                                    <Link
                                        href={route(
                                            'client.pick.reschedule',
                                            booking.id,
                                        )}
                                    >
                                        <Calendar className="mr-2 h-4 w-4" />
                                        Reschedule Booking
                                    </Link>
                                </Button>
                            </div>
                        </div>
                    </CardContent>
                </Card>
            )}

            {/* =============================== */}
            {/* LINK MEETING (ONLINE)           */}
            {/* =============================== */}
            {booking.consultation_type === 'online' && (
                <>
                    {booking.meeting_link ? (
                        <Card className="border-primary/30 bg-primary/5">
                            <CardContent className="p-4">
                                <div className="flex items-start gap-3">
                                    <Calendar className="mt-0.5 h-5 w-5 text-primary" />
                                    <div className="flex-1">
                                        <h4 className="mb-1 font-medium text-foreground">
                                            Link Konsultasi Tersedia
                                        </h4>
                                        <p className="mb-3 text-sm text-muted-foreground">
                                            Link meeting sudah siap. Anda dapat
                                            masuk ke ruang konsultasi sekarang.
                                        </p>
                                        <Button className="w-full" asChild>
                                            <a
                                                href={booking.meeting_link}
                                                target="_blank"
                                                rel="noopener noreferrer"
                                            >
                                                Masuk ke Sesi Konsultasi
                                            </a>
                                        </Button>
                                    </div>
                                </div>
                            </CardContent>
                        </Card>
                    ) : (
                        !isPast && (
                            <Card className="border-muted">
                                <CardContent className="p-4">
                                    <div className="flex items-start gap-3">
                                        <Clock className="mt-0.5 h-5 w-5 text-muted-foreground" />
                                        <div className="flex-1">
                                            <h4 className="mb-1 font-medium text-foreground">
                                                Menunggu Link Meeting
                                            </h4>
                                            <p className="text-sm text-muted-foreground">
                                                Konselor akan mengirimkan link
                                                sebelum sesi dimulai.
                                            </p>
                                        </div>
                                    </div>
                                </CardContent>
                            </Card>
                        )
                    )}
                </>
            )}
        </div>
    );
}

// Status: cancelled
export function CancelledStatus({ booking }: StatusComponentProps) {
    const cancelledBy =
        booking.cancelled_by === 'client'
            ? 'Dibatalkan oleh Anda'
            : booking.cancelled_by === 'counselor'
              ? 'Dibatalkan oleh Konselor'
              : booking.cancelled_by === 'admin'
                ? 'Dibatalkan oleh Admin'
                : 'Dibatalkan oleh Sistem';

    return (
        <div className="space-y-4">
            <Card className="border-destructive/30 bg-destructive/5">
                <CardContent className="p-4">
                    <div className="flex items-start gap-3">
                        <XCircle className="mt-0.5 h-5 w-5 text-destructive" />
                        <div className="flex-1">
                            <h4 className="mb-1 font-medium text-foreground">
                                Booking Dibatalkan
                            </h4>

                            <p className="mb-2 text-sm text-muted-foreground">
                                {cancelledBy}
                            </p>

                            {booking.cancel_reason && (
                                <p className="rounded-lg bg-background p-2 text-sm italic text-muted-foreground">
                                    Alasan: {booking.cancel_reason}
                                </p>
                            )}

                            {/* REFUND SEDANG DIPROSES */}
                            {booking.payment?.status === 'refund' && (
                                <p className="mt-3 text-sm text-blue-600">
                                    Dana sedang dalam proses pengembalian
                                    (refund).
                                </p>
                            )}

                            {/* REFUND SELESAI */}
                            {booking.payment?.status === 'refunded' && (
                                <p className="mt-3 text-sm font-medium text-green-600">
                                    Dana telah berhasil dikembalikan.
                                </p>
                            )}
                        </div>
                    </div>
                </CardContent>
            </Card>
        </div>
    );
}

export function ExpiredStatus({ booking }: StatusComponentProps) {
    return (
        <div className="space-y-4">
            <Card className="border-orange-300 bg-orange-50">
                <CardContent className="p-4">
                    <div className="flex items-start gap-3">
                        <Clock className="mt-0.5 h-5 w-5 text-orange-600" />

                        <div className="flex-1">
                            <h4 className="mb-1 font-medium text-foreground">
                                Pembayaran Kadaluarsa
                            </h4>

                            <p className="mb-2 text-sm text-muted-foreground">
                                Waktu pembayaran telah berakhir. Booking
                                dibatalkan otomatis oleh sistem.
                            </p>

                            {booking.cancel_reason && (
                                <p className="rounded-lg bg-background p-2 text-sm italic text-muted-foreground">
                                    Alasan: {booking.cancel_reason}
                                </p>
                            )}
                        </div>
                    </div>
                </CardContent>
            </Card>
        </div>
    );
}

// Status: completed
export function CompletedStatus({ booking }: StatusComponentProps) {
    return (
        <div className="space-y-4">
            {/* Alert Sesi Selesai */}
            <Card className="border-primary/30 bg-primary/5">
                <CardContent className="p-4">
                    <div className="flex items-start gap-3">
                        <CheckCircle2 className="mt-0.5 h-5 w-5 text-primary" />
                        <div className="flex-1">
                            <h4 className="mb-1 font-medium text-foreground">
                                Sesi Konsultasi Selesai
                            </h4>
                            <p className="text-sm text-muted-foreground">
                                Terima kasih telah menggunakan layanan kami.
                                Kami harap sesi konsultasi bermanfaat untuk
                                Anda.
                            </p>
                        </div>
                    </div>
                </CardContent>
            </Card>

            {/* Catatan Konselor */}
            {booking.counselor_notes && (
                <Card className="border-border bg-background">
                    <CardHeader>
                        <CardTitle className="text-lg">
                            Catatan Konselor
                        </CardTitle>
                    </CardHeader>
                    <CardContent>
                        <p className="whitespace-pre-line text-sm leading-relaxed text-muted-foreground">
                            {booking.counselor_notes}
                        </p>
                    </CardContent>
                </Card>
            )}
        </div>
    );
}

// Status: rescheduled
export function RescheduledStatus({ booking }: StatusComponentProps) {
    const previous = booking.previous_schedule;
    const previousSecond = booking.previous_second_schedule;

    const now = new Date();

    // Kombinasikan tanggal dan waktu jadwal baru untuk mendapatkan datetime lengkap
    const newSessionDateTime = new Date(
        `${booking.schedule.date}T${booking.schedule.start_time}`,
    );

    // Hitung selisih waktu dalam jam
    const hoursUntilSession =
        (newSessionDateTime.getTime() - now.getTime()) / (1000 * 60 * 60);
    const isTooCloseToSession = hoursUntilSession < 2 && hoursUntilSession > 0;
    const canReschedule = hoursUntilSession >= 2;

    return (
        <div className="space-y-4">
            {/* Alert Jadwal Diubah */}
            <Card className="border-warning/30 bg-warning/5">
                <CardContent className="p-4">
                    <div className="flex items-start gap-3">
                        <Calendar className="mt-0.5 h-5 w-5 text-warning" />
                        <div className="flex-1">
                            <h4 className="mb-1 font-medium text-foreground">
                                Jadwal Diubah
                            </h4>
                            <p className="mb-3 text-sm text-muted-foreground">
                                Booking ini telah dijadwalkan ulang. (Perubahan
                                jadwal masih menunggu persetujuan Konselor)
                            </p>

                            {/* === JADWAL SEBELUMNYA === */}
                            {previous && (
                                <div className="space-y-1 rounded-lg border bg-background p-3 text-sm">
                                    <p className="mb-1 text-muted-foreground">
                                        Jadwal Sebelumnya:
                                    </p>

                                    {/* Tanggal */}
                                    <p className="font-medium text-foreground">
                                        {previous.date}
                                    </p>

                                    {/* Slot Utama */}
                                    <p className="text-muted-foreground">
                                        {previous.start_time.substring(0, 5)} -{' '}
                                        {previous.end_time.substring(0, 5)}
                                    </p>

                                    {/* Slot kedua jika 2 sesi */}
                                    {previousSecond && (
                                        <p className="text-muted-foreground">
                                            &{' '}
                                            {previousSecond.start_time.substring(
                                                0,
                                                5,
                                            )}{' '}
                                            -{' '}
                                            {previousSecond.end_time.substring(
                                                0,
                                                5,
                                            )}
                                        </p>
                                    )}
                                </div>
                            )}
                        </div>
                    </div>
                </CardContent>
            </Card>

            {/* Peringatan jika terlalu dekat dengan sesi */}
            {isTooCloseToSession && (
                <Card className="border-orange-300 bg-orange-50">
                    <CardContent className="p-4">
                        <div className="flex items-start gap-3">
                            <Clock className="mt-0.5 h-5 w-5 text-orange-600" />
                            <div className="flex-1">
                                <h4 className="mb-1 font-medium text-foreground">
                                    Reschedule & Pembatalan Tidak Tersedia
                                </h4>
                                <p className="text-sm text-muted-foreground">
                                    Reschedule dan pembatalan hanya dapat
                                    dilakukan minimal 2 jam sebelum sesi
                                    dimulai. Silakan hubungi konselor jika ada
                                    kendala.
                                </p>
                            </div>
                        </div>
                    </CardContent>
                </Card>
            )}

            {/* Tombol reschedule jika masih memenuhi syarat waktu */}
            {canReschedule && booking.reschedule_status === 'approved' && (
                <Card className="border-primary/20 bg-primary/5">
                    <CardContent className="pt-6">
                        <div className="flex items-start gap-4">
                            <div className="rounded-full bg-primary/10 p-3">
                                <Calendar className="h-6 w-6 text-primary" />
                            </div>
                            <div className="flex-1">
                                <h3 className="mb-1 text-lg font-semibold">
                                    Perlu Mengubah Jadwal Lagi?
                                </h3>
                                <p className="mb-4 text-sm text-muted-foreground">
                                    Anda dapat melakukan reschedule ulang jika
                                    diperlukan. Reschedule hanya dapat dilakukan
                                    minimal 2 jam sebelum sesi.
                                </p>
                                <Button asChild>
                                    <Link
                                        href={route(
                                            'client.pick.reschedule',
                                            booking.id,
                                        )}
                                    >
                                        <Calendar className="mr-2 h-4 w-4" />
                                        Reschedule Ulang
                                    </Link>
                                </Button>
                            </div>
                        </div>
                    </CardContent>
                </Card>
            )}

            {/* Tombol Cancel Booking jika masih >= 2 jam */}
            {canReschedule && booking.reschedule_status === 'approved' && (
                <Card className="border-destructive/20 bg-destructive/5">
                    <CardContent className="pt-6">
                        <div className="flex items-start gap-4">
                            <div className="rounded-full bg-destructive/10 p-3">
                                <XCircle className="h-6 w-6 text-destructive" />
                            </div>
                            <div className="flex-1">
                                <h3 className="mb-1 text-lg font-semibold">
                                    Perlu Membatalkan Booking?
                                </h3>
                                <p className="mb-4 text-sm text-muted-foreground">
                                    Pembatalan hanya dapat dilakukan minimal 2
                                    jam sebelum sesi dimulai. Dana akan
                                    dikembalikan sesuai kebijakan refund.
                                </p>
                                <Button variant="destructive" asChild>
                                    <Link
                                        href={route(
                                            'client.booking.cancel',
                                            booking.id,
                                        )}
                                    >
                                        <XCircle className="mr-2 h-4 w-4" />
                                        Batalkan Booking
                                    </Link>
                                </Button>
                            </div>
                        </div>
                    </CardContent>
                </Card>
            )}

            {/* Tombol Aksi */}
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
