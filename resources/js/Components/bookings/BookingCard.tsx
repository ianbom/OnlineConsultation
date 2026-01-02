import { Avatar, AvatarFallback, AvatarImage } from '@/Components/ui/avatar';
import { Badge } from '@/Components/ui/badge';
import { Button } from '@/Components/ui/button';
import { Card, CardContent } from '@/Components/ui/card';
import { Link } from '@inertiajs/react';
import { Calendar, ChevronRight, Clock, MapPin, Video } from 'lucide-react';

interface BookingCardProps {
    id: number;
    counselorName: string;
    counselorPhoto: string;
    date: string;
    time: string;
    duration: string;
    status:
        | 'pending_payment'
        | 'paid'
        | 'cancelled'
        | 'completed'
        | 'rescheduled';
    specialization: string;
    bookingType: 'online' | 'offline';
    paymentStatus?: string;
    rescheduleStatus: string | null;
    rescheduleBy: string | null;
    showActions?: boolean;
}

export function BookingCard({
    id,
    counselorName,
    counselorPhoto,
    date,
    time,
    duration,
    status,
    specialization,
    bookingType,
    paymentStatus,
    rescheduleStatus = 'none',
    rescheduleBy,
    showActions = true,
}: BookingCardProps) {
    const getBadgeVariant = (status: string) => {
        switch (status) {
            case 'pending_payment':
                return 'outline';
            case 'paid':
                return 'default';
            case 'completed':
                return 'secondary';
            case 'cancelled':
                return 'destructive';
            case 'rescheduled':
                return 'default';
            default:
                return 'default';
        }
    };

    const getStatusText = (status: string, paymentStatus?: string) => {
        if (status === 'cancelled') {
            if (paymentStatus === 'refund') {
                return 'Dibatalkan · Refund Diproses';
            }
            if (paymentStatus === 'refunded') {
                return 'Dibatalkan · Dana Dikembalikan';
            }
            return 'Dibatalkan';
        }

        switch (status) {
            case 'pending_payment':
                return 'Menunggu Pembayaran';
            case 'paid':
                return 'Dibayar';
            case 'completed':
                return 'Selesai';
            case 'rescheduled':
                return 'Rescheduled';
            default:
                return status;
        }
    };

    const getRescheduleStatusBadge = (rescheduleStatus: string) => {
        switch (rescheduleStatus) {
            case 'pending':
                return {
                    variant: 'outline' as const,
                    text: 'Menunggu Persetujuan Reschedule',
                    className: 'border-yellow-500 text-yellow-700 bg-yellow-50',
                };
            case 'approved':
                return {
                    variant: 'default' as const,
                    text: 'Reschedule Disetujui',
                    className: 'bg-green-100 text-green-700 border-green-300',
                };
            case 'rejected':
                return {
                    variant: 'destructive' as const,
                    text: 'Reschedule Ditolak',
                    className: 'bg-red-100 text-red-700 border-red-300',
                };
            default:
                return null;
        }
    };

    const getRefundBadge = (paymentStatus?: string) => {
        if (paymentStatus === 'refund') {
            return {
                variant: 'outline' as const,
                text: 'Refund Diproses',
                className: 'border-blue-500 text-blue-700 bg-blue-50',
            };
        }

        if (paymentStatus === 'refunded') {
            return {
                variant: 'default' as const,
                text: 'Dana Dikembalikan',
                className: 'bg-green-100 text-green-700',
            };
        }

        return null;
    };

    const getRescheduleByText = (by?: string | null) => {
        switch (by) {
            case 'client':
                return 'Klien';
            case 'counselor':
                return 'Konselor';
            case 'admin':
                return 'Admin';
            default:
                return null;
        }
    };

    const getInitials = (name: string) =>
        name
            .split(' ')
            .map((n) => n[0])
            .join('')
            .toUpperCase()
            .substring(0, 2);

    const rescheduleStatusBadge = getRescheduleStatusBadge(
        rescheduleStatus ?? 'none',
    );
    const rescheduleByText = getRescheduleByText(rescheduleBy);
    const refundBadge = getRefundBadge(paymentStatus);

    return (
        <Card>
            <CardContent className="p-4">
                <div className="flex items-start gap-4">
                    <Avatar className="h-12 w-12 rounded-lg">
                        <AvatarImage src={counselorPhoto} alt={counselorName} />
                        <AvatarFallback className="rounded-lg">
                            {getInitials(counselorName)}
                        </AvatarFallback>
                    </Avatar>

                    <div className="min-w-0 flex-1">
                        {/* HEADER */}
                        <div className="flex items-start justify-between gap-2">
                            <div>
                                <h4 className="font-medium text-foreground">
                                    {counselorName}
                                </h4>
                                <p className="text-sm text-muted-foreground">
                                    {specialization}
                                </p>
                                <p className="mt-0.5 text-xs text-muted-foreground">
                                    Booking ID:{' '}
                                    <span className="font-medium">#{id}</span>
                                </p>
                            </div>

                            <div className="flex flex-col items-end gap-1">
                                {/* BOOKING STATUS */}
                                <Badge variant={getBadgeVariant(status) as any}>
                                    {getStatusText(status)}
                                </Badge>

                                {/* REFUND STATUS (JIKA ADA) */}
                                {status === 'cancelled' && refundBadge && (
                                    <Badge
                                        variant={refundBadge.variant}
                                        className={`text-xs ${refundBadge.className}`}
                                    >
                                        {refundBadge.text}
                                    </Badge>
                                )}
                            </div>
                        </div>

                        {/* RESCHEDULE STATUS ALERT */}
                        {rescheduleStatus !== 'none' &&
                            rescheduleStatusBadge && (
                                <div className="min-w-0 flex-1">
                                    {rescheduleByText && (
                                        <div className="mt-1.5 flex items-center gap-1.5 text-xs text-muted-foreground">
                                            <span>
                                                Permintaan Jadwal Ulang oleh:{' '}
                                                <span className="font-medium">
                                                    {rescheduleByText}
                                                </span>
                                            </span>
                                        </div>
                                    )}
                                </div>
                            )}

                        {/* META INFO */}
                        <div className="mt-3 flex flex-wrap items-center gap-4 text-sm text-muted-foreground">
                            <div className="flex items-center gap-1.5">
                                <Calendar className="h-4 w-4" />
                                <span>{date}</span>
                            </div>

                            <div className="flex items-center gap-1.5">
                                <Clock className="h-4 w-4" />
                                <span>
                                    {time} ({duration})
                                </span>
                            </div>

                            <div className="flex items-center gap-1.5">
                                {bookingType === 'online' ? (
                                    <>
                                        <Video className="h-4 w-4 text-blue-500" />
                                        <span className="font-medium text-blue-600">
                                            Online
                                        </span>
                                    </>
                                ) : (
                                    <>
                                        <MapPin className="h-4 w-4 text-green-500" />
                                        <span className="font-medium text-green-600">
                                            Offline
                                        </span>
                                    </>
                                )}
                            </div>
                        </div>

                        {/* ACTIONS */}
                        {showActions && (
                            <div className="mt-3 gap-2 border-t pt-3">
                                {status === 'rescheduled' &&
                                    rescheduleStatus === 'approved' && (
                                        <Badge
                                            variant="default"
                                            className="bg-green-100 px-3 py-1 text-green-700"
                                        >
                                            Jadwal Baru Tersedia
                                        </Badge>
                                    )}

                                {rescheduleStatus === 'pending' && (
                                    <Badge
                                        variant="outline"
                                        className="border-yellow-500 px-3 py-1 text-yellow-700"
                                    >
                                        Menunggu Konfirmasi
                                    </Badge>
                                )}

                                {rescheduleStatus === 'rejected' && (
                                    <Badge
                                        variant="destructive"
                                        className="px-3 py-1"
                                    >
                                        Reschedule Ditolak
                                    </Badge>
                                )}

                                <Button
                                    size="sm"
                                    variant="ghost"
                                    asChild
                                    className="ml-auto"
                                >
                                    <Link
                                        href={route(
                                            'client.booking.detail',
                                            id,
                                        )}
                                    >
                                        Detail
                                        <ChevronRight className="ml-1 h-4 w-4" />
                                    </Link>
                                </Button>
                            </div>
                        )}
                    </div>
                </div>
            </CardContent>
        </Card>
    );
}
