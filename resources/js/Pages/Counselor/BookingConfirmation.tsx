import { useState } from "react";
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
} from "lucide-react";
import { format } from "date-fns";
import { id as idLocale } from "date-fns/locale";

import { User, Counselor, Schedule } from "@/Interfaces";

interface Props {
  counselor: Counselor;
  schedules: Schedule[];
}

export default function BookingConfirmation({ counselor, schedules }: Props) {
  const [notes, setNotes] = useState("");
  const [consultationType, setConsultationType] = useState<"online" | "offline">("offline");
  const [isSubmitting, setIsSubmitting] = useState(false);

  const totalDuration = schedules.length * 60;
  const sessionFee = counselor.price_per_session * schedules.length;
  const total = sessionFee;

  const specializations = counselor.specialization.split(',').map(s => s.trim());

  const firstSchedule = schedules[0];
  const formattedDate = format(new Date(firstSchedule.date), "EEEE, d MMMM yyyy", { locale: idLocale });

  const timeRange = schedules.length > 0
    ? `${schedules[0].start_time.slice(0, 5)} - ${schedules[schedules.length - 1].end_time.slice(0, 5)}`
    : "";

  const formatRupiah = (amount: number) => {
    return new Intl.NumberFormat('id-ID', {
      style: 'currency',
      currency: 'IDR',
      minimumFractionDigits: 0,
    }).format(amount);
  };

  const handleProceed = () => {
    setIsSubmitting(true);

    // Prepare data sesuai dengan BookingRequest validation
    const data = {
      schedule_id: schedules[0].id,
      second_schedule_id: schedules.length > 1 ? schedules[1].id : null,
      consultation_type: consultationType,
      notes: notes || null,
    };

    // Submit ke controller store
    router.post(route('client.book.schedule', counselor.id), data, {
      onFinish: () => setIsSubmitting(false),
      onError: (errors) => {
        console.error('Booking errors:', errors);
        setIsSubmitting(false);
      }
    });
  };

  const profilePicUrl = counselor.user.profile_pic
    ? `/storage/${counselor.user.profile_pic}`
    : undefined;

  return (
    <PageLayout>
      <div className="max-w-lg mx-auto">
        {/* Back Button */}
        <Button variant="ghost" asChild className="mb-4">
          <Link href={route('client.pick.schedule', counselor.id)}>
            <ChevronLeft className="h-4 w-4 mr-1" />
            Kembali ke Jadwal
          </Link>
        </Button>

        <h1 className="font-display text-2xl font-semibold text-foreground mb-6">
          Konfirmasi Booking
        </h1>

        {/* Booking Receipt */}
        <Card className="mb-6">
          <CardHeader className="pb-4">
            <CardTitle className="text-lg">Ringkasan Booking</CardTitle>
          </CardHeader>
          <CardContent className="space-y-4">
            {/* Counselor Info */}
            <div className="flex items-center gap-4">
              <Avatar className="h-14 w-14 rounded-lg">
                <AvatarImage src={profilePicUrl} alt={counselor.user.name} />
                <AvatarFallback className="rounded-lg">
                  {counselor.user.name.split(" ").map((n) => n[0]).join("")}
                </AvatarFallback>
              </Avatar>
              <div>
                <h3 className="font-semibold text-foreground">{counselor.user.name}</h3>
                <p className="text-sm text-muted-foreground">{counselor.education}</p>
                <div className="flex flex-wrap gap-1 mt-1">
                  {specializations.slice(0, 2).map((spec, index) => (
                    <Badge key={index} variant="secondary" className="text-xs">
                      {spec}
                    </Badge>
                  ))}
                </div>
              </div>
            </div>

            <Separator />

            {/* Date & Time */}
            <div className="space-y-3">
              <div className="flex items-center justify-between">
                <div className="flex items-center gap-2 text-muted-foreground">
                  <Calendar className="h-4 w-4" />
                  <span>Tanggal</span>
                </div>
                <span className="font-medium text-foreground">
                  {formattedDate}
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
                  {totalDuration} menit ({schedules.length} sesi)
                </span>
              </div>
            </div>

            <Separator />

            {/* Price Breakdown */}
            <div className="space-y-2">
              <div className="flex items-center justify-between text-sm">
                <span className="text-muted-foreground">
                  Biaya Sesi ({schedules.length}x {formatRupiah(counselor.price_per_session)})
                </span>
                <span className="text-foreground">{formatRupiah(sessionFee)}</span>
              </div>

              <Separator />
              <div className="flex items-center justify-between">
                <span className="font-semibold text-foreground">Total</span>
                <span className="text-xl font-semibold text-foreground">
                  {formatRupiah(total)}
                </span>
              </div>
            </div>
          </CardContent>
        </Card>

        {/* Consultation Type */}
        <Card className="mb-6">
          <CardHeader className="pb-4">
            <CardTitle className="text-lg">Jenis Konsultasi</CardTitle>
          </CardHeader>

          <CardContent className="space-y-3">
            <div className="flex flex-col gap-3">
              {/* Offline Option */}
              <button
                onClick={() => setConsultationType("offline")}
                className={`
                  flex items-center gap-3 p-4 rounded-lg border text-left transition-all
                  ${consultationType === "offline"
                    ? "border-primary bg-primary/5"
                    : "border-border hover:border-primary/50"
                  }
                `}
              >
                <div
                  className={`
                    h-4 w-4 rounded-full border
                    ${consultationType === "offline" ? "bg-primary border-primary" : "border-muted-foreground"}
                  `}
                />
                <div>
                  <p className="font-medium text-foreground">Offline</p>
                  <p className="text-sm text-muted-foreground">
                    Tatap muka langsung di lokasi konselor
                  </p>
                </div>
              </button>

              {/* Online Option */}
              <button
                onClick={() => setConsultationType("online")}
                className={`
                  flex items-center gap-3 p-4 rounded-lg border text-left transition-all
                  ${consultationType === "online"
                    ? "border-primary bg-primary/5"
                    : "border-border hover:border-primary/50"
                  }
                `}
              >
                <div
                  className={`
                    h-4 w-4 rounded-full border
                    ${consultationType === "online" ? "bg-primary border-primary" : "border-muted-foreground"}
                  `}
                />
                <div>
                  <p className="font-medium text-foreground">Online</p>
                  <p className="text-sm text-muted-foreground">
                    Melalui video call (Google Meet / Zoom)
                  </p>
                </div>
              </button>
            </div>
          </CardContent>
        </Card>

        {/* Notes for Counselor */}
        <Card className="mb-6">
          <CardHeader className="pb-4">
            <CardTitle className="text-lg">Catatan untuk Konselor (Opsional)</CardTitle>
          </CardHeader>

          <CardContent>
            <textarea
              value={notes}
              onChange={(e) => setNotes(e.target.value)}
              placeholder="Tambahkan catatan penting sebelum sesi dimulai, misalnya: kondisi yang ingin dibahas, batasan waktu, atau permintaan khusus."
              className="
                w-full h-28 p-3 rounded-lg border border-border
                bg-background text-foreground text-sm
                focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent
                resize-none
              "
            />
          </CardContent>
        </Card>

        {/* Proceed Button */}
        <Button
          className="w-full"
          size="lg"
          onClick={handleProceed}
          disabled={isSubmitting}
        >
          {isSubmitting ? "Memproses..." : "Lanjut ke Pembayaran"}
        </Button>
      </div>
    </PageLayout>
  );
}
