import { Link } from "@inertiajs/react";
import { Calendar, Clock, ChevronRight } from "lucide-react";
import { Card, CardContent } from "@/Components/ui/card";
import { Badge } from "@/Components/ui/badge";
import { Button } from "@/Components/ui/button";
import { Avatar, AvatarFallback, AvatarImage } from "@/Components/ui/avatar";

interface BookingCardProps {
  id: number;
  counselorName: string;
  counselorPhoto: string;
  date: string;
  time: string;
  duration: string;
  status: "pending_payment" | "paid" | "cancelled" | "completed" | "rescheduled";
  specialization: string;
  paymentStatus?: string;
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
  paymentStatus,
  showActions = true,
}: BookingCardProps) {

  // Badge styling berdasarkan status baru
  const getBadgeVariant = (status: string) => {
    switch (status) {
      case "pending_payment":
        return "outline"; // kuning
      case "paid":
        return "default"; // biru/hijau
      case "completed":
        return "secondary"; // abu-abu
      case "cancelled":
        return "destructive"; // merah
      case "rescheduled":
        return "default"; // biru/hijau
      default:
        return "default";
    }
  };

  // Text status yang ditampilkan
  const getStatusText = (status: string) => {
    switch (status) {
      case "pending_payment":
        return "Menunggu Pembayaran";
      case "paid":
        return "Sudah Dibayar";
      case "completed":
        return "Selesai";
      case "cancelled":
        return "Dibatalkan";
      case "rescheduled":
        return "Dijadwalkan Ulang";
      default:
        return status;
    }
  };

  const getInitials = (name: string) =>
    name
      .split(" ")
      .map((n) => n[0])
      .join("")
      .toUpperCase()
      .substring(0, 2);

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

          <div className="flex-1 min-w-0">
            <div className="flex items-start justify-between gap-2">
              <div>
                <h4 className="font-medium text-foreground">{counselorName}</h4>
                <p className="text-sm text-muted-foreground">{specialization}</p>
              </div>

              <Badge variant={getBadgeVariant(status) as any}>
                {getStatusText(status)}
              </Badge>
            </div>

            <div className="flex flex-wrap items-center gap-4 mt-3 text-sm text-muted-foreground">
              <div className="flex items-center gap-1.5">
                <Calendar className="h-4 w-4" />
                <span>{date}</span>
              </div>

              <div className="flex items-center gap-1.5">
                <Clock className="h-4 w-4" />
                <span>{time} ({duration})</span>
              </div>
            </div>

            {/* ACTION BUTTONS */}
            {showActions && (
              <div className="flex items-center gap-2 mt-3 pt-3 border-t">

                {/* Jika dijadwalkan ulang */}
                {status === "rescheduled" && (
                  <Badge variant="default" className="px-3 py-1">
                    Jadwal Baru Tersedia
                  </Badge>
                )}

                <Button size="sm" variant="ghost" asChild>
                  <Link href={route('client.booking.detail',  id)}>
                    Detail
                    <ChevronRight className="h-4 w-4 ml-1" />
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
