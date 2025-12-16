import { Link } from "@inertiajs/react";
import { PageLayout } from "@/Components/layout/PageLayout";
import { Card, CardContent, CardHeader, CardTitle } from "@/Components/ui/card";
import { Button } from "@/Components/ui/button";
import { Badge } from "@/Components/ui/badge";
import { Avatar, AvatarFallback, AvatarImage } from "@/Components/ui/avatar";
import {
  Star,
  GraduationCap,
  Briefcase,
  Calendar,
  Clock,
  ChevronLeft,
} from "lucide-react";
import { User, WorkDay, Schedule, Counselor } from "@/Interfaces";

const dayNames = ["monday", "tuesday", "wednesday", "thursday", "friday"];
const dayLabels: Record<string, string> = {
  monday: "Senin",
  tuesday: "Selasa",
  wednesday: "Rabu",
  thursday: "Kamis",
  friday: "Jumat",
  saturday: "Sabtu",
  sunday: "Minggu",
};



interface Props {
  counselor: Counselor;
}

export default function CounselorProfile({ counselor }: Props) {

  const specializations = counselor.specialization
    .split(",")
    .map((s) => s.trim());

  const educationList = [counselor.education];

  // Hitung slot ketersediaan
  const availabilityByDay = dayNames.reduce((acc, day) => {
    const workDay = counselor.work_days.find(
      (wd) => wd.day_of_week.toLowerCase() === day && wd.is_active === 1
    );

    if (workDay) {
      const slots = counselor.schedules.filter(
        (schedule) =>
          schedule.workday_id === workDay.id && schedule.is_available === 1
      );
      acc[day] = slots.length;
    } else {
      acc[day] = 0;
    }

    return acc;
  }, {} as Record<string, number>);

  const profilePicUrl = counselor.user.profile_pic
    ? `/storage/${counselor.user.profile_pic}`
    : null;

  const isAvailable = counselor.status === "active";

  console.log('avaibility',availabilityByDay)

  return (
    <PageLayout>
      <div className="max-w-4xl mx-auto">

        {/* Tombol Kembali */}
        <Button variant="ghost" asChild className="mb-4">
          <Link href={route('client.counselor.list')}>
            <ChevronLeft className="h-4 w-4 mr-1" />
            Kembali ke Daftar Konselor
          </Link>
        </Button>

        {/* Header Profil */}
        <Card className="mb-6 overflow-hidden">
          <div className="h-24 gradient-primary" />
          <CardContent className="relative pt-0 pb-6">
            <div className="flex flex-col sm:flex-row gap-4 sm:items-end -mt-12">

              {/* Foto Profil */}
              <Avatar className="h-24 w-24 border-4 border-card rounded-xl">
                {profilePicUrl && (
                  <AvatarImage
                    src={profilePicUrl}
                    alt={counselor.user.name}
                    className="object-cover"
                  />
                )}
                <AvatarFallback className="text-2xl rounded-xl">
                  {counselor.user.name
                    .split(" ")
                    .map((n) => n[0])
                    .join("")}
                </AvatarFallback>
              </Avatar>

              {/* Nama & Status */}
              <div className="flex-1">
                  <div className="flex flex-col sm:flex-row sm:items-center gap-2 sm:gap-4">
                    <h1 className="font-display text-2xl font-semibold text-foreground">
                      {counselor.user.name}
                    </h1>
                                
                    <Badge
                      variant={isAvailable ? "success" : "secondary"}
                      className="
                        inline-flex
                        w-fit
                        px-2.5 py-0.5
                        text-xs
                        whitespace-nowrap
                        self-start
                        sm:self-auto
                      "
                    >
                      {isAvailable ? "Tersedia" : "Tidak Tersedia"}
                    </Badge>
                  </div>
                </div>


              {/* Harga */}
              <div className="text-right">
                <span className="text-2xl font-semibold text-foreground">
                  Rp {counselor.price_per_session.toLocaleString("id-ID")}
                </span>
                <span className="text-muted-foreground">/sesi</span>
              </div>
            </div>
          </CardContent>
        </Card>

        <div className="grid gap-6 md:grid-cols-3">
          {/* Konten Utama */}
          <div className="md:col-span-2 space-y-6">

            {/* Tentang Konselor */}
            <Card>
              <CardHeader>
                <CardTitle className="text-lg">Tentang Konselor</CardTitle>
              </CardHeader>
              <CardContent>
                <p className="text-muted-foreground leading-relaxed">
                  {counselor.description}
                </p>

                <div className="flex flex-wrap gap-2 mt-4">
                  {specializations.map((spec) => (
                    <Badge key={spec} variant="secondary">
                      {spec}
                    </Badge>
                  ))}
                </div>
              </CardContent>
            </Card>

            {/* Pendidikan */}
            <Card>
              <CardHeader>
                <CardTitle className="text-lg flex items-center gap-2">
                  <GraduationCap className="h-5 w-5 text-primary" />
                  Pendidikan
                </CardTitle>
              </CardHeader>
              <CardContent>
                <ul className="space-y-2">
                  {educationList.map((edu, index) => (
                    <li
                      key={index}
                      className="text-muted-foreground flex items-start gap-2"
                    >
                      <span className="h-1.5 w-1.5 rounded-full bg-primary mt-2 shrink-0" />
                      {edu}
                    </li>
                  ))}
                </ul>
              </CardContent>
            </Card>

            {/* Pengalaman */}
            <Card>
              <CardHeader>
                <CardTitle className="text-lg flex items-center gap-2">
                  <Briefcase className="h-5 w-5 text-primary" />
                  Pengalaman
                </CardTitle>
              </CardHeader>
              <CardContent>
                <p className="text-muted-foreground flex items-start gap-2">
                  <span className="h-1.5 w-1.5 rounded-full bg-primary mt-2 shrink-0" />
                  Konselor profesional dengan spesialisasi dalam{" "}
                  {specializations.join(", ")}
                </p>
              </CardContent>
            </Card>
          </div>

          {/* Sidebar */}
          <div className="space-y-6">

            {/* Ketersediaan */}
            <Card>
              <CardHeader>
                <CardTitle className="text-lg flex items-center gap-2">
                  <Calendar className="h-5 w-5 text-primary" />
                  Ketersediaan Jadwal
                </CardTitle>
              </CardHeader>
              <CardContent>
                <div className="space-y-3">
                  {dayNames.map((day) => {
                    const slots = availabilityByDay[day] || 0;
                    return (
                      <div
                        key={day}
                        className="flex items-center justify-between text-sm"
                      >
                        <span className="text-foreground font-medium">
                          {dayLabels[day]}
                        </span>
                        <span className="text-muted-foreground">
                          {slots > 0 ? `${slots} slot` : "Tidak tersedia"}
                        </span>
                      </div>
                    );
                  })}
                </div>
              </CardContent>
            </Card>

            {/* Booking CTA */}
            <Card className="border-primary/20 bg-primary/5">
              <CardContent className="p-5 space-y-4">

                <div className="flex items-center gap-2 text-foreground">
                  <Clock className="h-5 w-5 text-primary" />
                  <span className="font-medium">Durasi sesi 60 menit</span>
                </div>

                <div className="text-2xl font-semibold text-foreground">
                  Rp {counselor.price_per_session.toLocaleString("id-ID")}
                </div>

                <div className="space-y-2">
                  <Button className="w-full" size="lg" asChild>
                    <Link href={route('client.pick.schedule', counselor.id)}>
                      Pilih Jadwal
                    </Link>
                  </Button>
                </div>

              </CardContent>
            </Card>
          </div>
        </div>
      </div>
    </PageLayout>
  );
}
