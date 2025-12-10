// BookingDetailCard.tsx

import { Card, CardContent, CardHeader, CardTitle } from "@/Components/ui/card";
import { Avatar, AvatarFallback, AvatarImage } from "@/Components/ui/avatar";
import { Badge } from "@/Components/ui/badge";
import { Separator } from "@/Components/ui/separator";
import { Calendar, Clock, CreditCard } from "lucide-react";
import { format } from "date-fns";
import { id as idLocale } from "date-fns/locale";
import { Booking } from "@/Interfaces";

interface Props {
  booking: Booking;
}

export default function BookingDetailCard({ booking }: Props) {
  const baseUrl = import.meta.env.VITE_APP_URL;

  const photoUrl = booking.counselor.user.profile_pic
    ? `${baseUrl}/storage/${booking.counselor.user.profile_pic}`
    : "/default-avatar.png";

  const sessionDate = new Date(booking.schedule.date);
  const startTime = booking.schedule.start_time.substring(0, 5);
  const endTime =
    booking.second_schedule?.end_time?.substring(0, 5) ||
    booking.schedule.end_time.substring(0, 5);

  const timeRange = `${startTime} - ${endTime}`;
  const total = booking.payment?.amount ?? 0;

  const formatCurrency = (amount: number) =>
    new Intl.NumberFormat("id-ID", {
      style: "currency",
      currency: "IDR",
      minimumFractionDigits: 0,
    }).format(amount);

  const formatStatus = (status: string) =>
    status
      .replace(/_/g, " ")
      .split(" ")
      .map((w) => w.charAt(0).toUpperCase() + w.slice(1))
      .join(" ");

  return (
    <Card className="mb-6">
      <CardHeader className="pb-4">
        <CardTitle className="text-lg">
          Invoice #{booking.payment?.order_id}
        </CardTitle>
      </CardHeader>

      <CardContent className="space-y-4">
        {/* Konselor */}
        <div className="flex items-center gap-4">
          <Avatar className="h-14 w-14 rounded-lg">
            <AvatarImage src={photoUrl} alt={booking.counselor.user.name} />
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

        {/* Detail Jadwal */}
        <div className="space-y-3">
          <DetailRow
            icon={<Calendar className="h-4 w-4" />}
            label="Tanggal"
            value={format(sessionDate, "EEEE, d MMMM yyyy", { locale: idLocale })}
          />

          <DetailRow
            icon={<Clock className="h-4 w-4" />}
            label="Waktu"
            value={timeRange}
          />

          <DetailRow
            icon={<Clock className="h-4 w-4" />}
            label="Durasi"
            value={`${booking.duration_hours} jam`}
          />

          <DetailRow
            icon={<CreditCard className="h-4 w-4" />}
            label="Metode Pembayaran"
            value={formatStatus(booking.payment?.payment_type ?? "Belum")}
          />

          <DetailRow
            icon={<Calendar className="h-4 w-4" />}
            label="Jenis Konsultasi"
            value={booking.consultation_type}
          />
        </div>

        <Separator />

        {/* Total */}
        <div className="space-y-2">
          <div className="flex items-center justify-between text-sm">
            <span className="text-muted-foreground">Biaya Sesi</span>
            <span>{formatCurrency(booking.price)}</span>
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
  );
}

/* -----------------------------------------------------
   Sub-component kecil untuk baris detail
----------------------------------------------------- */

interface RowProps {
  icon: React.ReactNode;
  label: string;
  value: string | number;
}

function DetailRow({ icon, label, value }: RowProps) {
  return (
    <div className="flex items-center justify-between">
      <div className="flex items-center gap-2 text-muted-foreground">
        {icon}
        <span>{label}</span>
      </div>

      <span className="font-medium text-foreground">{value}</span>
    </div>
  );
}
