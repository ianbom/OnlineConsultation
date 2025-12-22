import { Link, router } from "@inertiajs/react";
import { PageLayout } from "@/Components/layout/PageLayout";
import { Card, CardContent, CardHeader, CardTitle } from "@/Components/ui/card";
import { Button } from "@/Components/ui/button";
import { Badge } from "@/Components/ui/badge";
import {
  ChevronLeft,
  Calendar,

} from "lucide-react";


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
import { useEffect, useState } from "react";

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

      const handleCancelBooking = () => {
      if (!confirm("Anda yakin ingin membatalkan booking ini?")) return;

      router.post(
        route("client.cancel.booking", booking.id),
        {
          reason: "Dibatalkan oleh client",
        },
        {
          preserveScroll: true,
        }
      );
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
          setTimeLeft("Kadaluarsa");
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
      <div className="max-w-4xl mx-auto px-4">
        <Button variant="ghost" asChild className="mb-4">
          <Link href={route("client.booking.history")}>
            <ChevronLeft className="h-4 w-4 mr-1" />
            Kembali ke Daftar Booking
          </Link>
        </Button>

        <div className="flex items-center justify-between mb-6">
          <div>
            <h1 className="font-display text-2xl font-semibold text-foreground">
              Detail Booking
            </h1>
          </div>

          <div className="flex items-center gap-4">
              {/* Status Badge */}
              <Badge
                variant={getBookingStatusBadge(booking.status) as any}
                className="text-sm"
              >
                {formatStatus(booking.status)}
              </Badge>

              {/* Countdown Payment Expiry */}
              {timeLeft && !booking.is_expired && booking.status == 'pending_payment' && (
                <div className="px-3 py-1 rounded-md bg-red-50 border border-red-200 text-red-600 text-xs font-medium">
                  {timeLeft === "Kadaluarsa" ? "Kadaluarsa" : `Sisa waktu: ${timeLeft}`}
                </div>
              )}

              {/* Cancel Button */}
              {["paid", "rescheduled"].includes(booking.status) && !booking.is_expired && (
                <Button
                  variant="destructive"
                  size="sm"
                  onClick={() => handleCancelBooking()}
                >
                  Cancel Booking
                </Button>
              )}
            </div>

        </div>

       <div className="space-y-6">
            <div className="grid grid-cols-1 lg:grid-cols-2 gap-6">

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
                      <CardTitle className="text-lg">Catatan Klien</CardTitle>
                    </CardHeader>
                    <CardContent>
                      <p className="text-muted-foreground">{booking.notes}</p>
                    </CardContent>
                  </Card>
                )}

                <Button variant="outline" className="w-full my-2 bg-amber-50 border-primary transition hover:bg-primary hover:border-white hover:text-white" asChild>
                  <Link href={route("client.booking.history")}>
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
