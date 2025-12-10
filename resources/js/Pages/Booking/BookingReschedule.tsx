import { Link, router } from "@inertiajs/react";
import { PageLayout } from "@/Components/layout/PageLayout";
import { Card, CardContent, CardHeader, CardTitle } from "@/Components/ui/card";
import { Button } from "@/Components/ui/button";
import { Alert, AlertDescription } from "@/Components/ui/alert";
import {
  ChevronLeft,
  Calendar,
  Clock,
  AlertCircle,
  Info,
  User,
} from "lucide-react";
import { format, addDays } from "date-fns";
import { id as idLocale } from "date-fns/locale";
import { useState } from "react";

import TimeSlots from "@/Components/schedule/TimeSlots";
import CalendarGrid from "@/Components/schedule/CalendarGrid";
import CalendarHeader from "@/Components/schedule/CalendarHeader";

import { Schedule, Counselor, Booking } from "@/Interfaces";



interface TimeSlot {
  id: number;
  time: string;
  startTime: string;
  endTime: string;
  isBooked: boolean;
}


interface Props {
  booking: Booking;
  counselor: Counselor;
  schedulesByDate: Record<string, Schedule[]>;
    // original booking info (optional). If provided, reschedule must match this session count.
    originalDurationHours?: 1 | 2;
    originalSecondScheduleId?: number | null;
  }



export default function BookingReschedule({ booking, counselor, schedulesByDate = {}, originalDurationHours, originalSecondScheduleId }: Props) {



  const [weekStart, setWeekStart] = useState(() => {
    const today = new Date();
    const day = today.getDay();
    const diff = day === 0 ? -6 : 1 - day;
    const monday = addDays(today, diff);
    monday.setHours(0, 0, 0, 0);
    return monday;
  });
  const [selectedDate, setSelectedDate] = useState<Date | null>(null);
  const [selectedSlots, setSelectedSlots] = useState<TimeSlot[]>([]);
  const [isRescheduling, setIsRescheduling] = useState(false);
    // Determine locked duration from original booking (either explicit prop or booking data)
    const initialDuration = (originalDurationHours ?? booking?.duration_hours ?? 1) as 1 | 2;
    const lockedDuration = typeof originalDurationHours !== 'undefined' || !!(booking && booking.duration_hours);
    const [durationHours, setDurationHours] = useState<1 | 2>(initialDuration);

  const weekDays = Array.from({ length: 7 }, (_, i) => addDays(weekStart, i));
  const maxSessions = durationHours;

  // Helper functions
  const isAdjacent = (time1: string, time2: string) => {
    const [h1, m1] = time1.split(":").map(Number);
    const [h2, m2] = time2.split(":").map(Number);
    const min1 = h1 * 60 + m1;
    const min2 = h2 * 60 + m2;
    return Math.abs(min2 - min1) === 60;
  };

  const canSelectSlot = (slot: TimeSlot) => {
    if (selectedSlots.length === 0) return true;
    if (maxSessions === 1) return false;
    if (selectedSlots.length === 1 && maxSessions === 2) {
      return isAdjacent(selectedSlots[0].time, slot.time);
    }
    return false;
  };

  const getAvailableSlots = (date: Date): TimeSlot[] => {
    const dateStr = format(date, "yyyy-MM-dd");
    const slots = schedulesByDate[dateStr] || [];

    return slots
      .filter((schedule) => schedule.is_available)
      .map((schedule) => ({
        id: schedule.id,
        time: schedule.start_time.substring(0, 5),
        startTime: schedule.start_time,
        endTime: schedule.end_time,
        isBooked: !schedule.is_available,
      }))
      .sort((a, b) => a.time.localeCompare(b.time));
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
      setSelectedSlots(selectedSlots.filter((s) => s.id !== slot.id));
      return;
    }

    if (selectedSlots.length >= maxSessions) return;
    if (!canSelectSlot(slot)) return;

    const sorted = [...selectedSlots, slot].sort((a, b) =>
      a.time.localeCompare(b.time)
    );

    setSelectedSlots(sorted);
  };

  const handleDurationChange = (hours: 1 | 2) => {
    if (lockedDuration) return; // duration locked to original booking
    setDurationHours(hours);
    setSelectedSlots([]);
  };

  const handleReschedule = () => {
    if (!selectedDate || selectedSlots.length !== durationHours) return;

    setIsRescheduling(true);

    const data: any = {
      schedule_id: selectedSlots[0].id,
      duration_hours: durationHours,
    };

    if (selectedSlots.length === 2) {
      data.second_schedule_id = selectedSlots[1].id;
    }

    router.post(
    route("client.reschedule.booking", booking.id),
      data,
      {
        onSuccess: () => {
        
        },
        onFinish: () => {
          setIsRescheduling(false);
        },
      }
    );
  };

  const availableSlots = selectedDate ? getAvailableSlots(selectedDate) : [];

  const baseUrl = import.meta.env.VITE_APP_URL;
  const photoUrl = counselor.user.profile_pic
    ? `${baseUrl}/storage/${counselor.user.profile_pic}`
    : "/default-avatar.png";

  return (
    <PageLayout>
      <div className="max-w-5xl mx-auto px-4">
        <Button variant="ghost" asChild className="mb-4">
          <Link href={route("client.booking.history")}>
            <ChevronLeft className="h-4 w-4 mr-1" />
            Kembali ke Riwayat Booking
          </Link>
        </Button>

        <div className="mb-6">
          <h1 className="font-display text-2xl font-semibold text-foreground mb-2">
            Reschedule Booking
          </h1>
          <p className="text-muted-foreground">
            Pilih jadwal baru untuk sesi konseling Anda
          </p>
        </div>

        <div className="grid lg:grid-cols-3 gap-6">
          {/* Sidebar - Info Konselor & Durasi */}
          <div className="lg:col-span-1">
            <Card className="sticky top-4">
              <CardHeader>
                <CardTitle className="text-lg">Info Konselor</CardTitle>
              </CardHeader>
              <CardContent className="space-y-4">
                <div className="flex items-center gap-3">
                  <div className="relative h-12 w-12 rounded-full overflow-hidden bg-muted">
                    <img
                      src={photoUrl}
                      alt={counselor.user.name}
                      className="h-full w-full object-cover"
                      onError={(e) => {
                        e.currentTarget.src = "/default-avatar.png";
                      }}
                    />
                  </div>
                  <div>
                    <p className="font-medium">{counselor.user.name}</p>
                    <p className="text-sm text-muted-foreground">Konselor</p>
                  </div>
                </div>

                <div className="border-t pt-4">
                  <p className="text-sm font-medium mb-3">Pilih Durasi Sesi</p>
                  <div className="space-y-2">
                    <button
                      onClick={() => handleDurationChange(1)}
                      disabled={lockedDuration}
                      className={`w-full p-3 rounded-lg border-2 transition-colors text-left ${
                        durationHours === 1
                          ? "border-primary bg-primary/5"
                          : "border-border hover:border-primary/50"
                      } ${lockedDuration ? 'opacity-60 cursor-not-allowed' : ''}`}
                    >
                      <div className="flex items-center justify-between">
                        <div>
                          <p className="font-medium">1 Jam</p>
                          <p className="text-sm text-muted-foreground">Sesi standar</p>
                        </div>
                        <Clock className="h-5 w-5 text-muted-foreground" />
                      </div>
                    </button>

                    <button
                      onClick={() => handleDurationChange(2)}
                      disabled={lockedDuration}
                      className={`w-full p-3 rounded-lg border-2 transition-colors text-left ${
                        durationHours === 2
                          ? "border-primary bg-primary/5"
                          : "border-border hover:border-primary/50"
                      } ${lockedDuration ? 'opacity-60 cursor-not-allowed' : ''}`}
                    >
                      <div className="flex items-center justify-between">
                        <div>
                          <p className="font-medium">2 Jam</p>
                          <p className="text-sm text-muted-foreground">Sesi extended</p>
                        </div>
                        <Clock className="h-5 w-5 text-muted-foreground" />
                      </div>
                    </button>
                  </div>
                </div>

                {durationHours === 2 && (
                  <Alert>
                    <Info className="h-4 w-4" />
                    <AlertDescription className="text-xs">
                      Untuk sesi 2 jam, Anda perlu memilih 2 slot waktu yang berurutan.
                    </AlertDescription>
                  </Alert>
                )}
              </CardContent>
            </Card>
          </div>

          {/* Main Content - Calendar & Time Slots */}
          <div className="lg:col-span-2">
            <Card>
              <CardHeader>
                <CardTitle className="flex items-center gap-2">
                  <Calendar className="h-5 w-5" />
                  Pilih Jadwal Baru
                </CardTitle>
              </CardHeader>
              <CardContent className="space-y-4">
                <Alert>
                  <Info className="h-4 w-4" />
                  <AlertDescription>
                    Pilih tanggal dan waktu baru untuk sesi konseling Anda.
                    {durationHours === 2 && " Pilih 2 slot waktu yang berurutan untuk sesi 2 jam."}
                  </AlertDescription>
                </Alert>

                {/* Calendar Header */}
                <CalendarHeader
                  weekStart={weekStart}
                  onPrevWeek={handlePrevWeek}
                  onNextWeek={handleNextWeek}
                />

                {/* Grid Tanggal */}
                <CalendarGrid
                  weekDays={weekDays}
                  selectedDate={selectedDate}
                  onSelectDate={handleDateSelect}
                  getAvailableSlots={getAvailableSlots}
                />

                {/* Slot Waktu */}
                {selectedDate && (
                  <>
                    <TimeSlots
                      selectedDate={selectedDate}
                      availableSlots={availableSlots}
                      selectedSlots={selectedSlots}
                      canSelectSlot={canSelectSlot}
                      onSelectSlot={handleSlotSelect}
                    />

                    {availableSlots.length === 0 && (
                      <Alert>
                        <AlertCircle className="h-4 w-4" />
                        <AlertDescription>
                          Tidak ada slot waktu tersedia untuk tanggal ini.
                        </AlertDescription>
                      </Alert>
                    )}
                  </>
                )}

                {/* Selected Info & Button */}
                {selectedSlots.length > 0 && (
                  <div className="space-y-3 pt-4 border-t">
                    <div className="bg-primary/5 p-4 rounded-lg space-y-2">
                      <p className="font-medium text-sm">Jadwal Baru:</p>
                      <div className="flex items-start gap-2">
                        <Calendar className="h-4 w-4 mt-0.5 text-primary" />
                        <div className="text-sm">
                          <p className="font-medium">
                            {selectedDate && format(selectedDate, "EEEE, dd MMMM yyyy", { locale: idLocale })}
                          </p>
                          <p className="text-muted-foreground">
                            {selectedSlots[0].time} - {selectedSlots[selectedSlots.length - 1].endTime.substring(0, 5)}
                          </p>
                          <p className="text-xs text-muted-foreground mt-1">
                            Durasi: {durationHours} jam
                          </p>
                        </div>
                      </div>
                      {maxSessions === 2 && selectedSlots.length === 1 && (
                        <Alert>
                          <AlertCircle className="h-4 w-4" />
                          <AlertDescription>
                            Pilih 1 slot lagi yang berurutan untuk sesi 2 jam.
                          </AlertDescription>
                        </Alert>
                      )}
                    </div>

                    <div className="flex gap-3">
                      <Button
                        variant="outline"
                        onClick={() => {
                          setSelectedDate(null);
                          setSelectedSlots([]);
                        }}
                        className="flex-1"
                      >
                        Reset
                      </Button>
                      <Button
                        onClick={handleReschedule}
                        disabled={isRescheduling || selectedSlots.length !== durationHours}
                        className="flex-1"
                      >
                        {isRescheduling ? "Memproses..." : "Konfirmasi Reschedule"}
                      </Button>
                    </div>
                  </div>
                )}

                {!selectedDate && (
                  <div className="text-center py-12">
                    <Calendar className="h-12 w-12 text-muted-foreground/50 mx-auto mb-3" />
                    <p className="text-sm text-muted-foreground">
                      Pilih tanggal untuk melihat slot waktu yang tersedia
                    </p>
                  </div>
                )}
              </CardContent>
            </Card>
          </div>
        </div>
      </div>
    </PageLayout>
  );
}
