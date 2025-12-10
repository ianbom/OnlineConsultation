import { Link, router } from "@inertiajs/react";
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
  ChevronRight,
  AlertCircle,
} from "lucide-react";
import { format, addDays, isSameDay } from "date-fns";
import { id as idLocale } from "date-fns/locale";

import { Booking } from "@/Interfaces";
import {
  PendingPaymentStatus,
  PaidStatus,
  CancelledStatus,
  CompletedStatus,
  RescheduledStatus,
  ExpiredStatus,
} from "@/Components/bookings/BookingStatusComponents";
import BookingDetailCard from "@/Components/bookings/DetailBookingCard";

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

  const formatStatus = (status: string) => {
    return status
      .replace(/_/g, " ")
      .split(" ")
      .map((word) => word.charAt(0).toUpperCase() + word.slice(1))
      .join(" ");
  };

  const formatCurrency = (amount: number) => {
    return new Intl.NumberFormat("id-ID", {
      style: "currency",
      currency: "IDR",
      minimumFractionDigits: 0,
    }).format(amount);
  };

  const renderStatusComponent = () => {
    if (booking.is_expired) {
      return <ExpiredStatus booking={booking} />;
    }

    if (booking.status === "cancelled") {
      return <CancelledStatus booking={booking} />;
    }

    switch (booking.status) {
      case "pending_payment":
        return <PendingPaymentStatus booking={booking} />;
      case "paid":
        return <PaidStatus booking={booking} />;
      case "completed":
        return <CompletedStatus booking={booking} />;
      case "rescheduled":
        return <RescheduledStatus booking={booking} />;
      default:
        return null;
    }
  };

  const showRescheduleButton = booking.status === "paid" && !booking.is_expired;

  return (
    <PageLayout>
      <div className="max-w-xl mx-auto px-4">
        <Button variant="ghost" asChild className="mb-4">
          <Link href={route("client.booking.history")}>
            <ChevronLeft className="h-4 w-4 mr-1" />
            Kembali ke Daftar Booking
          </Link>
        </Button>

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

        <div className="space-y-6">
          <BookingDetailCard booking={booking} />

          {booking.notes && (
            <Card>
              <CardHeader>
                <CardTitle className="text-lg">Catatan Klien</CardTitle>
              </CardHeader>
              <CardContent>
                <p className="text-muted-foreground">{booking.notes}</p>
              </CardContent>
            </Card>
          )}

          <div>{renderStatusComponent()}</div>

           {showRescheduleButton && (
            <Card className="border-primary/20 bg-primary/5">
              <CardContent className="pt-6">
                <div className="flex items-start gap-4">
                  <div className="p-3 rounded-full bg-primary/10">
                    <Calendar className="h-6 w-6 text-primary" />
                  </div>
                  <div className="flex-1">
                    <h3 className="font-semibold text-lg mb-1">
                      Perlu Mengubah Jadwal?
                    </h3>
                    <p className="text-muted-foreground text-sm mb-4">
                      Anda dapat melakukan reschedule sesi konseling ini jika ada perubahan jadwal.
                    </p>
                    <Button asChild>
                      <Link href={route('client.pick.reschedule', booking.id)}>
                        <Calendar className="h-4 w-4 mr-2" />
                        Reschedule Booking
                      </Link>
                    </Button>
                  </div>
                </div>
              </CardContent>
            </Card>
          )}


          <Button variant="outline" className="w-full" asChild>
            <Link href={route("client.booking.history")}>
              Lihat Semua Booking
            </Link>
          </Button>
        </div>
      </div>
    </PageLayout>
  );
}
