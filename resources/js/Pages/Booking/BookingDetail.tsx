import { useState } from "react";
import { Link } from "@inertiajs/react";
import { PageLayout } from "@/Components/layout/PageLayout";
import { Card, CardContent, CardHeader, CardTitle } from "@/Components/ui/card";
import { Button } from "@/Components/ui/button";
import { Badge } from "@/Components/ui/badge";
import { Avatar, AvatarFallback, AvatarImage } from "@/Components/ui/avatar";
import { Separator } from "@/Components/ui/separator";
import {
  ChevronLeft,
  Calendar,
  Clock,
  CreditCard,
} from "lucide-react";
import { format } from "date-fns";
import { id as idLocale } from "date-fns/locale";

import { Booking } from "@/Interfaces";
import {
  PendingPaymentStatus,
  PaidStatus,
  CancelledStatus,
  CompletedStatus,
  RescheduledStatus,
} from "@/Components/bookings/BookingStatusComponents";

interface Props {
  booking: Booking;
}

export default function BookingDetail({ booking }: Props) {
  const baseUrl = import.meta.env.VITE_APP_URL;
  const photoUrl = booking.counselor.user.profile_pic
    ? `${baseUrl}/storage/${booking.counselor.user.profile_pic}`
    : "/default-avatar.png";

  // Badge status booking
  const getBookingStatusBadge = (status: string) => {
    const statusMap: Record<string, string> = {
      pending_payment: "warning",
      paid: "success",
      completed: "default",
      cancelled: "destructive",
      rescheduled: "secondary",
    };
    return statusMap[status] || "secondary";
  };

  // Format status ke huruf besar per kata
  const formatStatus = (status: string) => {
    return status
      .replace(/_/g, " ")
      .split(" ")
      .map((word) => word.charAt(0).toUpperCase() + word.slice(1))
      .join(" ");
  };

  const total = booking.payment.amount;

  const sessionDate = new Date(booking.schedule.date);
  const startTime = booking.schedule.start_time.substring(0, 5);
  const endTime =
    booking.second_schedule?.end_time.substring(0, 5) ||
    booking.schedule.end_time.substring(0, 5);
  const timeRange = `${startTime} - ${endTime}`;

  const formatCurrency = (amount: number) => {
    return new Intl.NumberFormat("id-ID", {
      style: "currency",
      currency: "IDR",
      minimumFractionDigits: 0,
    }).format(amount);
  };

  // Render komponen status berdasarkan status booking
  const renderStatusComponent = () => {
    switch (booking.status) {
      case "pending_payment":
        return <PendingPaymentStatus booking={booking} />;
      case "paid":
        return <PaidStatus booking={booking} />;
      case "cancelled":
        return <CancelledStatus booking={booking} />;
      case "completed":
        return <CompletedStatus booking={booking} />;
      case "rescheduled":
        return <RescheduledStatus booking={booking} />;
      default:
        return null;
    }
  };

  return (
    <PageLayout>
      <div className="max-w-lg mx-auto">
        {/* Tombol Kembali */}
        <Button variant="ghost" asChild className="mb-4">
          <Link href={route("client.booking.history")}>
            <ChevronLeft className="h-4 w-4 mr-1" />
            Kembali ke Daftar Booking
          </Link>
        </Button>

        {/* Header Status */}
        <div className="flex items-center justify-between mb-6">
          <h1 className="font-display text-2xl font-semibold text-foreground">
            Detail Booking
          </h1>
          <Badge
            variant={getBookingStatusBadge(booking.status) as any}
            className="text-sm"
          >
            {formatStatus(booking.status)}
          </Badge>
        </div>

        {/* Kartu Invoice */}
        <Card className="mb-6">
          <CardHeader className="pb-4">
            <CardTitle className="text-lg">
              Invoice #{booking.payment.order_id}
            </CardTitle>
          </CardHeader>

          <CardContent className="space-y-4">
            {/* Info Konselor */}
            <div className="flex items-center gap-4">
              <Avatar className="h-14 w-14 rounded-lg">
                <AvatarImage
                  src={photoUrl}
                  alt={booking.counselor.user.name}
                />
                <AvatarFallback className="rounded-lg">
                  {booking.counselor.user.name
                    .split(" ")
                    .map((n) => n[0])
                    .join("")}
                </AvatarFallback>
              </Avatar>

              <div>
                <h3 className="font-semibold text-foreground">
                  {booking.counselor.user.name}
                </h3>
                <Badge variant="secondary" className="text-xs mt-1">
                  {booking.counselor.specialization}
                </Badge>
              </div>
            </div>

            <Separator />

            {/* Detail Sesi */}
            <div className="space-y-3">
              <div className="flex items-center justify-between">
                <div className="flex items-center gap-2 text-muted-foreground">
                  <Calendar className="h-4 w-4" />
                  <span>Tanggal</span>
                </div>
                <span className="font-medium text-foreground">
                  {format(sessionDate, "EEEE, d MMMM yyyy", {
                    locale: idLocale,
                  })}
                </span>
              </div>

              <div className="flex items-center justify-between">
                <div className="flex items-center gap-2 text-muted-foreground">
                  <Clock className="h-4 w-4" />
                  <span>Waktu</span>
                </div>
                <span className="font-medium text-foreground">{timeRange}</span>
              </div>

              <div className="flex items-center justify-between">
                <div className="flex items-center gap-2 text-muted-foreground">
                  <Clock className="h-4 w-4" />
                  <span>Durasi</span>
                </div>
                <span className="font-medium text-foreground">
                  {booking.duration_hours}{" "}
                  {booking.duration_hours > 1 ? "jam" : "jam"}
                </span>
              </div>

              <div className="flex items-center justify-between">
                <div className="flex items-center gap-2 text-muted-foreground">
                  <CreditCard className="h-4 w-4" />
                  <span>Metode Pembayaran</span>
                </div>
                <span className="font-medium text-foreground">
                  {formatStatus(booking.payment.method)}
                </span>
              </div>

              <div className="flex items-center justify-between">
                <div className="flex items-center gap-2 text-muted-foreground">
                  <Calendar className="h-4 w-4" />
                  <span>Jenis Konsultasi</span>
                </div>
                <span className="font-medium text-foreground capitalize">
                  {booking.consultation_type}
                </span>
              </div>
            </div>

            <Separator />

            {/* Total Pembayaran */}
            <div className="space-y-2">
              <div className="flex items-center justify-between text-sm">
                <span className="text-muted-foreground">Biaya Sesi</span>
                <span className="text-foreground">
                  {formatCurrency(booking.price)}
                </span>
              </div>

              <Separator />

              <div className="flex items-center justify-between">
                <span className="font-semibold text-foreground">Total</span>
                <span className="text-xl font-semibold text-foreground">
                  {formatCurrency(total)}
                </span>
              </div>
            </div>
          </CardContent>
        </Card>

        {/* Catatan */}
        {booking.notes && (
          <Card className="mb-6">
            <CardHeader>
              <CardTitle className="text-lg">Catatan Klien</CardTitle>
            </CardHeader>
            <CardContent>
              <p className="text-muted-foreground">{booking.notes}</p>
            </CardContent>
          </Card>
        )}

        {/* Komponen Status Dinamis */}
        <div className="mb-6">{renderStatusComponent()}</div>

        {/* Tombol Lihat Semua Booking */}
        <Button variant="outline" className="w-full" asChild>
          <Link href="/bookings">Lihat Semua Booking</Link>
        </Button>
      </div>
    </PageLayout>
  );
}
