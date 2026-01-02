import { BookingCard } from '@/Components/bookings/BookingCard';
import { PageLayout } from '@/Components/layout/PageLayout';
import { Button } from '@/Components/ui/button';
import { Card, CardContent, CardHeader, CardTitle } from '@/Components/ui/card';
import { Link } from '@inertiajs/react';
import { Calendar, ChevronRight, Clock, CreditCard, Users } from 'lucide-react';

import { CtaCard } from '@/Components/ui/CtaCard';
import { Booking } from '@/Interfaces';

interface DashboardProps {
    upcomingBooking: Booking[];
    completedBooking: Booking[];
    pendingPaymentBooking: Booking[];
    recentConsultations: Booking[];
}

export default function Dashboard({
    upcomingBooking = [],
    completedBooking = [],
    pendingPaymentBooking = [],
    recentConsultations = [],
}: DashboardProps) {
    const stats = [
        {
            label: 'Sesi Mendatang',
            value: upcomingBooking.length,
            icon: Calendar,
            color: 'text-info',
            bgColor: 'bg-info/10',
        },
        {
            label: 'Sesi Selesai',
            value: completedBooking.length,
            icon: Clock,
            color: 'text-success',
            bgColor: 'bg-success/10',
        },
        {
            label: 'Pembayaran Tertunda',
            value: pendingPaymentBooking.length,
            icon: CreditCard,
            color: 'text-warning',
            bgColor: 'bg-warning/10',
        },
    ];

    const formatTime = (time: string) => {
        return time.substring(0, 5); // "13:00:00" -> "13:00"
    };

    const formatDate = (date: string) => {
        return new Date(date).toLocaleDateString('id-ID', {
            weekday: 'long',
            year: 'numeric',
            month: 'long',
            day: 'numeric',
        });
    };

    const getImageUrl = (profilePic: string) => {
        if (!profilePic) return '/images/default-avatar.png';
        if (profilePic.startsWith('http')) return profilePic;
        return `/storage/${profilePic}`;
    };

    return (
        <PageLayout
            title="Selamat Datang Kembali"
            description="Berikut adalah ringkasan penggunaan Persona Quality"
        >
            {/* Stats Grid */}
            <div className="mb-6 grid gap-4 sm:grid-cols-3">
                {stats.map((stat) => (
                    <Card key={stat.label}>
                        <CardContent className="p-4">
                            <div className="flex items-center gap-4">
                                <div
                                    className={`flex h-12 w-12 items-center justify-center rounded-xl ${stat.bgColor}`}
                                >
                                    <stat.icon
                                        className={`h-6 w-6 ${stat.color}`}
                                    />
                                </div>
                                <div>
                                    <p className="text-2xl font-semibold text-foreground">
                                        {stat.value}
                                    </p>
                                    <p className="text-sm text-muted-foreground">
                                        {stat.label}
                                    </p>
                                </div>
                            </div>
                        </CardContent>
                    </Card>
                ))}
            </div>

            {/* Quick Actions */}
            <CtaCard />

            {/* Booking Cards Grid */}
            <div className="my-6 mb-6 grid gap-4 lg:grid-cols-2">
                {/* Upcoming Schedule */}
                <Card>
                    <CardHeader className="flex-row items-center justify-between pb-3">
                        <CardTitle className="text-base">
                            Sesi Mendatang
                        </CardTitle>
                        <Button variant="ghost" size="sm" asChild>
                            <Link href="/client/booking-history">
                                Lihat Semua{' '}
                                <ChevronRight className="ml-1 h-4 w-4" />
                            </Link>
                        </Button>
                    </CardHeader>
                    <CardContent className="space-y-2">
                        {upcomingBooking.length > 0 ? (
                            upcomingBooking
                                .slice(0, 2)
                                .map((booking) => (
                                    <BookingCard
                                        key={booking.id}
                                        id={booking.id}
                                        counselorName={
                                            booking.counselor.user.name
                                        }
                                        counselorPhoto={getImageUrl(
                                            booking.counselor.user
                                                .profile_pic ?? '',
                                        )}
                                        date={formatDate(booking.schedule.date)}
                                        time={`${formatTime(booking.schedule.start_time)} - ${
                                            booking.second_schedule
                                                ? formatTime(
                                                      booking.second_schedule
                                                          .end_time,
                                                  )
                                                : formatTime(
                                                      booking.schedule.end_time,
                                                  )
                                        }`}
                                        duration={`${booking.duration_hours} hour${booking.duration_hours > 1 ? 's' : ''}`}
                                        status={booking.status as any}
                                        specialization={
                                            booking.counselor.specialization
                                        }
                                        showActions={false}
                                        bookingType={booking.consultation_type}
                                        rescheduleStatus={
                                            booking.reschedule_status
                                        }
                                        rescheduleBy={booking.reschedule_by}
                                        paymentStatus={
                                            booking.payment?.status ?? 'pending'
                                        }
                                    />
                                ))
                        ) : (
                            <div className="flex flex-col items-center justify-center px-4 py-12">
                                <div className="relative mb-4">
                                    <div className="absolute inset-0 rounded-full bg-primary/5 blur-2xl"></div>
                                    <div className="relative rounded-full bg-gradient-to-br from-primary/10 to-primary/5 p-6">
                                        <Calendar className="h-12 w-12 text-primary" />
                                    </div>
                                </div>
                                <h3 className="mb-1 text-base font-semibold text-foreground">
                                    Belum Ada Sesi Terjadwal
                                </h3>
                                <p className="mb-4 max-w-xs text-center text-sm text-muted-foreground">
                                    Jadwalkan konsultasi pertama Anda dengan
                                    konselor profesional kami
                                </p>
                                <Button size="sm" asChild>
                                    <Link href="/client/list-counselors">
                                        <Calendar className="mr-2 h-4 w-4" />
                                        Buat Jadwal Baru
                                    </Link>
                                </Button>
                            </div>
                        )}
                    </CardContent>
                </Card>

                {/* Recent History */}
                <Card>
                    <CardHeader className="flex-row items-center justify-between pb-3">
                        <CardTitle className="text-base">
                            Konsultasi Terbaru
                        </CardTitle>
                        <Button variant="ghost" size="sm" asChild>
                            <Link href="/client/booking-history">
                                Lihat Riwayat{' '}
                                <ChevronRight className="ml-1 h-4 w-4" />
                            </Link>
                        </Button>
                    </CardHeader>
                    <CardContent className="space-y-2">
                        {recentConsultations.length > 0 ? (
                            recentConsultations
                                .slice(0, 2)
                                .map((booking) => (
                                    <BookingCard
                                        key={booking.id}
                                        id={booking.id}
                                        counselorName={
                                            booking.counselor.user.name
                                        }
                                        counselorPhoto={getImageUrl(
                                            booking.counselor.user
                                                .profile_pic ?? '',
                                        )}
                                        date={formatDate(booking.schedule.date)}
                                        time={`${formatTime(booking.schedule.start_time)} - ${
                                            booking.second_schedule
                                                ? formatTime(
                                                      booking.second_schedule
                                                          .end_time,
                                                  )
                                                : formatTime(
                                                      booking.schedule.end_time,
                                                  )
                                        }`}
                                        duration={`${booking.duration_hours} hour${booking.duration_hours > 1 ? 's' : ''}`}
                                        status={booking.status as any}
                                        specialization={
                                            booking.counselor.specialization
                                        }
                                        showActions={false}
                                        bookingType={booking.consultation_type}
                                        rescheduleStatus={
                                            booking.reschedule_status
                                        }
                                        rescheduleBy={booking.reschedule_by}
                                        paymentStatus={
                                            booking.payment?.status ?? 'pending'
                                        }
                                    />
                                ))
                        ) : (
                            <div className="flex flex-col items-center justify-center px-4 py-12">
                                <div className="relative mb-4">
                                    <div className="absolute inset-0 rounded-full bg-success/5 blur-2xl"></div>
                                    <div className="relative rounded-full bg-gradient-to-br from-success/10 to-success/5 p-6">
                                        <Clock className="h-12 w-12 text-success" />
                                    </div>
                                </div>
                                <h3 className="mb-1 text-base font-semibold text-foreground">
                                    Belum Ada Riwayat Konsultasi
                                </h3>
                                <p className="mb-4 max-w-xs text-center text-sm text-muted-foreground">
                                    Mulai perjalanan kesehatan mental Anda
                                    bersama konselor terpercaya
                                </p>
                                <Button size="sm" variant="outline" asChild>
                                    <Link href="/client/list-counselors">
                                        <Users className="mr-2 h-4 w-4" />
                                        Lihat Konselor
                                    </Link>
                                </Button>
                            </div>
                        )}
                    </CardContent>
                </Card>
            </div>
        </PageLayout>
    );
}
