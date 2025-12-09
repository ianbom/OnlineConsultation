import { Link } from "@inertiajs/react";
import { Button } from "@/Components/ui/button";
import { Card, CardContent } from "@/Components/ui/card";
import {
  AlertCircle,
  CheckCircle2,
  XCircle,
  Clock,
  Calendar,
  ExternalLink,
  Copy,
} from "lucide-react";
import { useState } from "react";
import { useToast } from "@/hooks/use-toast";
import { Booking } from "@/Interfaces";

interface StatusComponentProps {
  booking: Booking;
}

// Status: pending_payment
export function PendingPaymentStatus({ booking }: StatusComponentProps) {
  const { toast } = useToast();
  const [copied, setCopied] = useState(false);

  const handleCopyLink = () => {
    navigator.clipboard.writeText(booking.payment.payment_url ?? "");
    setCopied(true);
    toast({
      title: "Link disalin",
      description: "Link pembayaran berhasil disalin ke clipboard",
    });
    setTimeout(() => setCopied(false), 2000);
  };

  return (
    <div className="space-y-4">
      {/* Alert Pembayaran Tertunda */}
     <Card className="border-warning/30 bg-warning/5">
          <CardContent className="p-4">
            <div className="flex items-start gap-3 w-full">
              <AlertCircle className="h-5 w-5 text-warning mt-0.5" />

              <div className="flex-1 min-w-0"> {/* mencegah overflow */}
                <h4 className="font-medium text-foreground mb-1">
                  Menunggu Pembayaran
                </h4>

                <p className="text-sm text-muted-foreground mb-3 break-words">
                  Silakan selesaikan pembayaran untuk mengonfirmasi booking Anda.
                  Booking akan otomatis dibatalkan jika pembayaran tidak diselesaikan
                  dalam 15 menit.
                </p>

                {/* Link Pembayaran */}
                <div className="flex items-center gap-2 mb-3 w-full">
                  <div className="flex-1 bg-background rounded-lg p-3 text-sm font-mono
                    text-muted-foreground truncate max-w-full overflow-hidden">
                    {booking.payment.payment_url}
                  </div>

                  <Button variant="outline" size="icon" onClick={handleCopyLink}>
                    {copied ? (
                      <CheckCircle2 className="h-4 w-4 text-success" />
                    ) : (
                      <Copy className="h-4 w-4" />
                    )}
                  </Button>

                  <Button variant="outline" size="icon" asChild>
                    <a
                      href={booking.payment.payment_url ?? ""}
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
            href={booking.payment.payment_url ?? ""}
            target="_blank"
            rel="noopener noreferrer"
          >
            Bayar Sekarang
          </a>
        </Button>
        <Button className="w-full" size="lg" variant="outline" asChild>
          <Link href={route("client.payment.check", booking.id)}>
            Cek Status Pembayaran
          </Link>
        </Button>
      </div>
    </div>
  );
}

// Status: paid (confirmed)
export function PaidStatus({ booking }: StatusComponentProps) {
  const sessionDate = new Date(booking.schedule.date);
  const now = new Date();
  const isPast = sessionDate < now;

  return (
    <div className="space-y-4">
      {/* Alert Pembayaran Berhasil */}
      <Card className="border-success/30 bg-success/5">
        <CardContent className="p-4">
          <div className="flex items-start gap-3">
            <CheckCircle2 className="h-5 w-5 text-success mt-0.5" />
            <div className="flex-1">
              <h4 className="font-medium text-foreground mb-1">
                Pembayaran Berhasil
              </h4>
              <p className="text-sm text-muted-foreground">
                Booking Anda telah dikonfirmasi. {!isPast && "Konselor akan mengirimkan link meeting sebelum sesi dimulai."}
              </p>
            </div>
          </div>
        </CardContent>
      </Card>

      {/* Info Link Meeting */}
      {booking.meeting_link ? (
        <Card className="border-primary/30 bg-primary/5">
          <CardContent className="p-4">
            <div className="flex items-start gap-3">
              <Calendar className="h-5 w-5 text-primary mt-0.5" />
              <div className="flex-1">
                <h4 className="font-medium text-foreground mb-1">
                  Link Konsultasi Tersedia
                </h4>
                <p className="text-sm text-muted-foreground mb-3">
                  Link meeting sudah siap. Anda dapat masuk ke ruang konsultasi
                  sekarang.
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
                <Clock className="h-5 w-5 text-muted-foreground mt-0.5" />
                <div className="flex-1">
                  <h4 className="font-medium text-foreground mb-1">
                    Menunggu Link Meeting
                  </h4>
                  <p className="text-sm text-muted-foreground">
                    Konselor akan mengirimkan link meeting sebelum sesi dimulai.
                    Anda akan menerima notifikasi saat link tersedia.
                  </p>
                </div>
              </div>
            </CardContent>
          </Card>
        )
      )}
    </div>
  );
}

// Status: cancelled
export function CancelledStatus({ booking }: StatusComponentProps) {
  return (
    <div className="space-y-4">
      {/* Alert Booking Dibatalkan */}
      <Card className="border-destructive/30 bg-destructive/5">
        <CardContent className="p-4">
          <div className="flex items-start gap-3">
            <XCircle className="h-5 w-5 text-destructive mt-0.5" />
            <div className="flex-1">
              <h4 className="font-medium text-foreground mb-1">
                Booking Dibatalkan
              </h4>
              <p className="text-sm text-muted-foreground">
                Booking ini telah dibatalkan. Jika Anda sudah melakukan pembayaran,
                dana akan dikembalikan dalam 3-5 hari kerja.
              </p>
            </div>
          </div>
        </CardContent>
      </Card>

      {/* Tombol Booking Baru */}
      <Button className="w-full" size="lg" variant="outline" asChild>
        <Link href="/counselors">Cari Konselor Lain</Link>
      </Button>
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
            <CheckCircle2 className="h-5 w-5 text-primary mt-0.5" />
            <div className="flex-1">
              <h4 className="font-medium text-foreground mb-1">
                Sesi Konsultasi Selesai
              </h4>
              <p className="text-sm text-muted-foreground">
                Terima kasih telah menggunakan layanan kami. Kami harap sesi
                konsultasi bermanfaat untuk Anda.
              </p>
            </div>
          </div>
        </CardContent>
      </Card>

      {/* Tombol Aksi */}
      <div className="space-y-2">
        <Button className="w-full" size="lg" asChild>
          <Link href={`/counselors/${booking.counselor_id}`}>
            Booking Lagi dengan {booking.counselor.user.name}
          </Link>
        </Button>
        <Button className="w-full" size="lg" variant="outline" asChild>
          <Link href="/counselors">Cari Konselor Lain</Link>
        </Button>
      </div>
    </div>
  );
}

// Status: rescheduled
export function RescheduledStatus({ booking }: StatusComponentProps) {
  return (
    <div className="space-y-4">
      {/* Alert Jadwal Diubah */}
      <Card className="border-warning/30 bg-warning/5">
        <CardContent className="p-4">
          <div className="flex items-start gap-3">
            <Calendar className="h-5 w-5 text-warning mt-0.5" />
            <div className="flex-1">
              <h4 className="font-medium text-foreground mb-1">
                Jadwal Diubah
              </h4>
              <p className="text-sm text-muted-foreground mb-3">
                Booking ini telah dijadwalkan ulang. Informasi jadwal di atas
                adalah jadwal yang baru.
              </p>

              {/* Info Jadwal Lama */}
              {booking.previous_schedule_id && (
                <div className="bg-background rounded-lg p-3 text-sm">
                  <p className="text-muted-foreground mb-1">Jadwal sebelumnya:</p>
                  <p className="text-foreground">
                    Lihat riwayat perubahan untuk detail jadwal lama
                  </p>
                </div>
              )}
            </div>
          </div>
        </CardContent>
      </Card>

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
