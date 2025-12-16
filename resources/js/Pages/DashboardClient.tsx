import { useState } from "react";
import { Link } from "@inertiajs/react";
import { PageLayout } from "@/Components/layout/PageLayout";
import { Card, CardContent, CardHeader, CardTitle } from "@/Components/ui/card";
import { Button } from "@/Components/ui/button";
import { BookingCard } from "@/Components/bookings/BookingCard";
import { Calendar, Clock, CreditCard, ChevronRight, Users } from "lucide-react";

import { User, Schedule, Booking ,Counselor, Payment } from "@/Interfaces";
import { CtaCard } from "@/Components/ui/CtaCard";



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
      label: "Sesi Mendatang",
      value: upcomingBooking.length,
      icon: Calendar,
      color: "text-info",
      bgColor: "bg-info/10",
    },
    {
      label: "Sesi Selesai",
      value: completedBooking.length,
      icon: Clock,
      color: "text-success",
      bgColor: "bg-success/10",
    },
    {
      label: "Pembayaran Tertunda",
      value: pendingPaymentBooking.length,
      icon: CreditCard,
      color: "text-warning",
      bgColor: "bg-warning/10",
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
      day: 'numeric'
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
      <div className="grid gap-4 sm:grid-cols-3 mb-6">
        {stats.map((stat) => (
          <Card key={stat.label}>
            <CardContent className="p-4">
              <div className="flex items-center gap-4">
                <div className={`flex h-12 w-12 items-center justify-center rounded-xl ${stat.bgColor}`}>
                  <stat.icon className={`h-6 w-6 ${stat.color}`} />
                </div>
                <div>
                  <p className="text-2xl font-semibold text-foreground">{stat.value}</p>
                  <p className="text-sm text-muted-foreground">{stat.label}</p>
                </div>
              </div>
            </CardContent>
          </Card>
        ))}
      </div>

      {/* Quick Actions */}
      <CtaCard/>

      {/* Booking Cards Grid */}
      <div className="grid gap-4 lg:grid-cols-2 mb-6 my-6">
        {/* Upcoming Schedule */}
        <Card>
          <CardHeader className="flex-row items-center justify-between pb-3">
            <CardTitle className="text-base">Sesi Mendatang</CardTitle>
            <Button variant="ghost" size="sm" asChild>
              <Link href="/client/booking-history">
                Lihat Semua <ChevronRight className="h-4 w-4 ml-1" />
              </Link>
            </Button>
          </CardHeader>
          <CardContent className="space-y-2">
            {upcomingBooking.length > 0 ? (
              upcomingBooking.slice(0, 2).map((booking) => (
                <BookingCard
                  key={booking.id}
                  id={booking.id}
                  counselorName={booking.counselor.user.name}
                  counselorPhoto={getImageUrl(booking.counselor.user.profile_pic ?? '')}
                  date={formatDate(booking.schedule.date)}
                  time={`${formatTime(booking.schedule.start_time)} - ${
                    booking.second_schedule
                      ? formatTime(booking.second_schedule.end_time)
                      : formatTime(booking.schedule.end_time)
                  }`}
                  duration={`${booking.duration_hours} hour${booking.duration_hours > 1 ? 's' : ''}`}
                  status={booking.status as any}
                  specialization={booking.counselor.specialization}
                  showActions={false}
                  bookingType={booking.consultation_type}
                  rescheduleStatus={booking.reschedule_status }
                  rescheduleBy={booking.reschedule_by}
                  paymentStatus={booking.payment?.status ?? "pending"}
                />
              ))
            ) : (
              <div className="text-center py-6 text-muted-foreground text-sm">
                Tidak ada sesi mendatang
              </div>
            )}
          </CardContent>
        </Card>

        {/* Recent History */}
        <Card>
          <CardHeader className="flex-row items-center justify-between pb-3">
            <CardTitle className="text-base">Konsultasi Terbaru</CardTitle>
            <Button variant="ghost" size="sm" asChild>
              <Link href="/client/booking-history">
                Lihat Riwayat <ChevronRight className="h-4 w-4 ml-1" />
              </Link>
            </Button>
          </CardHeader>
          <CardContent className="space-y-2">
            {recentConsultations.length > 0 ? (
              recentConsultations.slice(0, 2).map((booking) => (
                <BookingCard
                  key={booking.id}
                  id={booking.id}
                  counselorName={booking.counselor.user.name}
                  counselorPhoto={getImageUrl(booking.counselor.user.profile_pic ?? '')}
                  date={formatDate(booking.schedule.date)}
                  time={`${formatTime(booking.schedule.start_time)} - ${
                    booking.second_schedule
                      ? formatTime(booking.second_schedule.end_time)
                      : formatTime(booking.schedule.end_time)
                  }`}
                  duration={`${booking.duration_hours} hour${booking.duration_hours > 1 ? 's' : ''}`}
                  status={booking.status as any}
                  specialization={booking.counselor.specialization}
                  showActions={false}
                  bookingType={booking.consultation_type}
                  rescheduleStatus={booking.reschedule_status }
                  rescheduleBy={booking.reschedule_by}
                  paymentStatus={booking.payment?.status ?? "pending"}
                />
              ))
            ) : (
              <div className="text-center py-6 text-muted-foreground text-sm">
                Tidak ada konsultasi terbaru
              </div>
            )}
          </CardContent>
        </Card>
      </div>

      {/* Pending Payment */}
      {/* {pendingPaymentBooking.length > 0 && (
        <Card className="border-warning/30 bg-warning/5">
          <CardContent className="p-4">
            <div className="flex items-start gap-3">
              <div className="flex h-10 w-10 items-center justify-center rounded-full bg-warning/10">
                <CreditCard className="h-5 w-5 text-warning" />
              </div>
              <div className="flex-1">
                <h4 className="font-medium text-foreground">Payment Pending</h4>
                <p className="text-sm text-muted-foreground mt-0.5">
                  You have {pendingPaymentBooking.length} pending payment{pendingPaymentBooking.length > 1 ? 's' : ''}
                </p>
                <Button variant="accent" size="sm" className="mt-3" asChild>
                  <Link href="/client/booking-history">View Payments</Link>
                </Button>
              </div>
            </div>
          </CardContent>
        </Card>
      )} */}
    </PageLayout>
  );
}
