import { useState, useMemo } from "react";
import { Link, router } from "@inertiajs/react";
import { PageLayout } from "@/Components/layout/PageLayout";
import { Card, CardContent, CardHeader, CardTitle } from "@/Components/ui/card";
import { Button } from "@/Components/ui/button";
import { Avatar, AvatarFallback, AvatarImage } from "@/Components/ui/avatar";
import { ChevronLeft, ChevronRight, Clock } from "lucide-react";
import { format, addDays, startOfWeek, isSameDay } from "date-fns";

import { User, Schedule, Counselor } from "@/Interfaces";

interface Props {
  counselor: Counselor;
}

interface TimeSlot {
  id: number;
  time: string;
  startTime: string;
  endTime: string;
  isBooked: boolean;
}

export default function SchedulePicker({ counselor }: Props) {
  const [weekStart, setWeekStart] = useState(startOfWeek(new Date(), { weekStartsOn: 1 }));
  const [selectedDate, setSelectedDate] = useState<Date | null>(null);
  const [selectedSlots, setSelectedSlots] = useState<TimeSlot[]>([]);

  const weekDays = Array.from({ length: 7 }, (_, i) => addDays(weekStart, i));

  // Kelompokkan jadwal berdasarkan tanggal
  const schedulesByDate = useMemo(() => {
    const grouped: Record<string, Schedule[]> = {};

    counselor.schedules.forEach((schedule) => {
      if (schedule.is_available === 1) {
        const dateKey = schedule.date;
        if (!grouped[dateKey]) {
          grouped[dateKey] = [];
        }
        grouped[dateKey].push(schedule);
      }
    });

    return grouped;
  }, [counselor.schedules]);

  const getAvailableSlots = (date: Date): TimeSlot[] => {
    const dateStr = format(date, "yyyy-MM-dd");
    const slots = schedulesByDate[dateStr] || [];

    // Sort slots by start time
    return slots
      .map((schedule) => ({
        id: schedule.id,
        time: schedule.start_time.substring(0, 5),
        startTime: schedule.start_time,
        endTime: schedule.end_time,
        isBooked: false,
      }))
      .sort((a, b) => a.time.localeCompare(b.time));
  };

  // Cek apakah dua waktu berdampingan (selisih 1 jam)
  const isAdjacent = (time1: string, time2: string) => {
    const [h1] = time1.split(":").map(Number);
    const [h2] = time2.split(":").map(Number);
    return Math.abs(h1 - h2) === 1;
  };

  // Cek apakah slot dapat dipilih
  const canSelectSlot = (slot: TimeSlot) => {
    if (selectedSlots.length === 0) return true;
    if (selectedSlots.length === 1) {
      return isAdjacent(selectedSlots[0].time, slot.time);
    }
    return false; // Sudah 2 slot terpilih
  };

  const handlePrevWeek = () => {
    setWeekStart(addDays(weekStart, -7));
    setSelectedDate(null);
    setSelectedSlots([]);
  };

  const handleNextWeek = () => {
    setWeekStart(addDays(weekStart, 7));
    setSelectedDate(null);
    setSelectedSlots([]);
  };

  const handleDateSelect = (date: Date) => {
    setSelectedDate(date);
    setSelectedSlots([]);
  };

  const handleSlotSelect = (slot: TimeSlot) => {
    const isSelected = selectedSlots.some((s) => s.id === slot.id);

    if (isSelected) {
      // Unselect
      setSelectedSlots(selectedSlots.filter((s) => s.id !== slot.id));
    } else if (canSelectSlot(slot)) {
      // Select and sort by time
      const newSlots = [...selectedSlots, slot].sort((a, b) =>
        a.time.localeCompare(b.time)
      );
      setSelectedSlots(newSlots);
    }
  };

  const handleContinue = () => {
    if (selectedSlots.length > 0) {
      const scheduleIds = selectedSlots.map((slot) => slot.id).join(",");
      router.visit(
        route('client.process.payment', {
          counselorId: counselor.id,
          scheduleIds: scheduleIds
        })
      );
    }
  };

  const availableSlots = selectedDate ? getAvailableSlots(selectedDate) : [];

  const profilePicUrl = counselor.user.profile_pic
    ? `/storage/${counselor.user.profile_pic}`
    : null;

  // Hitung total harga
  const totalPrice = counselor.price_per_session * selectedSlots.length;

  return (
    <PageLayout>
      <div className="max-w-3xl mx-auto">
        {/* Tombol Kembali */}
        <Button variant="ghost" asChild className="mb-4">
          <Link href={route('client.counselor.show', counselor.id)}>
            <ChevronLeft className="h-4 w-4 mr-1" />
            Kembali ke Profil
          </Link>
        </Button>

        {/* Informasi Konselor */}
        <Card className="mb-6">
          <CardContent className="p-4">
            <div className="flex items-center gap-4">
              <Avatar className="h-14 w-14 rounded-lg">
                <AvatarImage src={profilePicUrl || undefined} alt={counselor.user.name} />
                <AvatarFallback className="rounded-lg">
                  {counselor.user.name.split(" ").map((n) => n[0]).join("")}
                </AvatarFallback>
              </Avatar>
              <div>
                <h2 className="font-semibold text-foreground">
                  {counselor.user.name}
                </h2>
                <p className="text-sm text-muted-foreground">
                  Rp {counselor.price_per_session.toLocaleString("id-ID")} per sesi
                </p>
                <p className="text-xs text-muted-foreground mt-1">
                  Pilih 1-2 jam konseling yang berdampingan
                </p>
              </div>
            </div>
          </CardContent>
        </Card>

        {/* Kalender */}
        <Card className="mb-6">
          <CardHeader className="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
            <CardTitle className="text-lg text-center sm:text-left">
              Pilih Tanggal
            </CardTitle>

            <div className="flex items-center justify-center sm:justify-end gap-2 w-full sm:w-auto">
              <Button variant="ghost" size="icon" onClick={handlePrevWeek}>
                <ChevronLeft className="h-4 w-4" />
              </Button>

              <span className="text-sm font-medium text-foreground min-w-[140px] text-center">
                {format(weekStart, "d MMM")} - {format(addDays(weekStart, 6), "d MMM yyyy")}
              </span>

              <Button variant="ghost" size="icon" onClick={handleNextWeek}>
                <ChevronRight className="h-4 w-4" />
              </Button>
            </div>
          </CardHeader>

          <CardContent>
            <div
              className="
                grid
                grid-cols-3        /* mobile */
                sm:grid-cols-5     /* tablet */
                md:grid-cols-7     /* desktop */
                gap-2
              "
            >
              {weekDays.map((date) => {
                const slots = getAvailableSlots(date);
                const availableCount = slots.length;
                const isSelected = selectedDate && isSameDay(date, selectedDate);

                const today = new Date();
                today.setHours(0, 0, 0, 0);
                const isPast = date < today;

                return (
                  <button
                    key={date.toISOString()}
                    disabled={isPast || availableCount === 0}
                    onClick={() => handleDateSelect(date)}
                    className={`
                      p-3 rounded-lg border text-center transition-all
                      flex flex-col items-center justify-center
                      text-xs sm:text-sm               /* responsive text */
                      min-h-[60px] sm:min-h-[70px]     /* responsive height */

                      ${
                        isSelected
                          ? "border-primary bg-primary text-primary-foreground"
                          : "border-border hover:border-primary/50"
                      }
                      ${(isPast || availableCount === 0) && "opacity-50 cursor-not-allowed"}
                    `}
                  >
                    <div className="font-medium opacity-70">
                      {format(date, "EEE")}
                    </div>

                    <div className="text-base sm:text-lg font-semibold mt-1">
                      {format(date, "d")}
                    </div>

                    {availableCount > 0 && (
                      <div
                        className={`mt-1 ${
                          isSelected ? "text-primary-foreground/80" : "text-primary"
                        }`}
                      >
                        {availableCount} slot
                      </div>
                    )}
                  </button>
                );
              })}
            </div>
          </CardContent>
        </Card>

        {/* Slot Waktu */}
        {selectedDate && (
          <Card className="mb-24 animate-fade-in">
            <CardHeader>
              <CardTitle className="text-lg">
                Waktu Tersedia untuk {format(selectedDate, "EEEE, d MMMM")}
              </CardTitle>
              <p className="text-sm text-muted-foreground">
                Pilih maksimal 2 jam yang berdampingan
              </p>
            </CardHeader>

            <CardContent>
              {availableSlots.length > 0 ? (
                <div className="grid grid-cols-3 sm:grid-cols-4 md:grid-cols-5 gap-2">
                  {availableSlots.map((slot) => {
                    const isSelected = selectedSlots.some((s) => s.id === slot.id);
                    const canSelect = canSelectSlot(slot);
                    const isDisabled = slot.isBooked || (!isSelected && !canSelect);

                    return (
                      <button
                        key={slot.id}
                        disabled={isDisabled}
                        onClick={() => handleSlotSelect(slot)}
                        className={`
                          flex items-center justify-center gap-1.5 p-3 rounded-lg border text-sm font-medium transition-all
                          ${isSelected
                            ? "border-primary bg-primary text-primary-foreground ring-2 ring-primary ring-offset-2"
                            : canSelect
                            ? "border-border hover:border-primary/50"
                            : "border-border"
                          }
                          ${isDisabled && "opacity-50 cursor-not-allowed"}
                          ${slot.isBooked && "bg-muted line-through"}
                        `}
                      >
                        <Clock className="h-4 w-4" />
                        {slot.time}
                      </button>
                    );
                  })}
                </div>
              ) : (
                <p className="text-center text-muted-foreground py-8">
                  Tidak ada jadwal tersedia di tanggal ini
                </p>
              )}
            </CardContent>
          </Card>
        )}

        {/* Footer Sticky */}
        {selectedDate && selectedSlots.length > 0 && (
          <div className="fixed bottom-0 left-0 right-0 p-4 bg-card border-t shadow-lg animate-slide-up z-50">
            <div
              className="
                max-w-3xl mx-auto
                flex flex-col sm:flex-row
                items-start sm:items-center
                gap-3 sm:gap-0
                justify-between
              "
            >
              {/* Info Terpilih */}
              <div className="w-full sm:w-auto">
                <p className="text-sm text-muted-foreground">Terpilih</p>
                <p className="font-medium text-foreground">
                  {format(selectedDate, "d MMM yyyy")} • {selectedSlots.map(s => s.time).join(", ")}
                </p>
                <p className="text-sm text-muted-foreground mt-1">
                  Total: Rp {totalPrice.toLocaleString("id-ID")} ({selectedSlots.length} sesi)
                </p>
              </div>

              {/* Tombol */}
              <Button
                size="lg"
                onClick={handleContinue}
                className="
                  w-full sm:w-auto
                  text-center
                  flex items-center justify-center
                "
              >
                Lanjutkan Pemesanan
                <ChevronRight className="h-4 w-4 ml-1" />
              </Button>
            </div>
          </div>
        )}

      </div>
    </PageLayout>
  );
}
