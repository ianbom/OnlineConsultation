import { DurationSelector } from '@/Components/bookings/DurationSelector';
import { SelectedScheduleSummary } from '@/Components/bookings/SelectedScheduleSummary';
import { PageLayout } from '@/Components/layout/PageLayout';
import CalendarGrid from '@/Components/schedule/CalendarGrid';
import CalendarHeader from '@/Components/schedule/CalendarHeader';
import TimeSlots from '@/Components/schedule/TimeSlots';
import { Alert, AlertDescription } from '@/Components/ui/alert';
import { Button } from '@/Components/ui/button';
import { Card, CardContent, CardHeader, CardTitle } from '@/Components/ui/card';
import { Booking, Counselor, Schedule } from '@/Interfaces';
import { getProfilePicUrl } from '@/utils/booking';
import { Link, router } from '@inertiajs/react';
import { addDays, format } from 'date-fns';
import { AlertCircle, Calendar, ChevronLeft, Info } from 'lucide-react';
import { useState } from 'react';

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
    originalDurationHours?: 1 | 2;
    originalSecondScheduleId?: number | null;
}

export default function BookingReschedule({
    booking,
    counselor,
    schedulesByDate = {},
    originalDurationHours,
}: Props) {
    // Week navigation state
    const [weekStart, setWeekStart] = useState(() => {
        const today = new Date();
        const day = today.getDay();
        const diff = day === 0 ? -6 : 1 - day;
        const monday = addDays(today, diff);
        monday.setHours(0, 0, 0, 0);
        return monday;
    });

    // Selection state
    const [selectedDate, setSelectedDate] = useState<Date | null>(null);
    const [selectedSlots, setSelectedSlots] = useState<TimeSlot[]>([]);
    const [isRescheduling, setIsRescheduling] = useState(false);

    // Duration state
    const initialDuration = (originalDurationHours ??
        booking?.duration_hours ??
        1) as 1 | 2;
    const lockedDuration =
        typeof originalDurationHours !== 'undefined' ||
        !!(booking && booking.duration_hours);
    const [durationHours, setDurationHours] = useState<1 | 2>(initialDuration);

    const weekDays = Array.from({ length: 7 }, (_, i) => addDays(weekStart, i));
    const maxSessions = durationHours;
    const photoUrl = getProfilePicUrl(counselor.user.profile_pic);

    // Helper functions
    const isAdjacent = (time1: string, time2: string) => {
        const [h1, m1] = time1.split(':').map(Number);
        const [h2, m2] = time2.split(':').map(Number);
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
        const dateStr = format(date, 'yyyy-MM-dd');
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

    // Event handlers
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
            a.time.localeCompare(b.time),
        );
        setSelectedSlots(sorted);
    };

    const handleDurationChange = (hours: 1 | 2) => {
        if (lockedDuration) return;
        setDurationHours(hours);
        setSelectedSlots([]);
    };

    const handleReset = () => {
        setSelectedDate(null);
        setSelectedSlots([]);
    };

    const handleReschedule = () => {
        if (!selectedDate || selectedSlots.length !== durationHours) return;

        setIsRescheduling(true);

        // eslint-disable-next-line @typescript-eslint/no-explicit-any
        const data: any = {
            schedule_id: selectedSlots[0].id,
            duration_hours: durationHours,
        };

        if (selectedSlots.length === 2) {
            data.second_schedule_id = selectedSlots[1].id;
        }

        router.post(route('client.reschedule.booking', booking.id), data, {
            onSuccess: () => {},
            onFinish: () => {
                setIsRescheduling(false);
            },
        });
    };

    const availableSlots = selectedDate ? getAvailableSlots(selectedDate) : [];

    return (
        <PageLayout>
            <div className="mx-auto max-w-5xl px-4">
                <Button variant="ghost" asChild className="mb-4">
                    <Link href={route('client.booking.detail', booking.id)}>
                        <ChevronLeft className="mr-1 h-4 w-4" />
                        Kembali ke Detail Booking
                    </Link>
                </Button>

                <div className="mb-6">
                    <h1 className="mb-2 font-display text-2xl font-semibold text-foreground">
                        Reschedule Booking
                    </h1>
                    <p className="text-muted-foreground">
                        Pilih jadwal baru untuk sesi konseling Anda
                    </p>
                </div>

                <div className="grid gap-6 lg:grid-cols-3">
                    {/* Sidebar - Info Konselor & Durasi */}
                    <div className="lg:col-span-1">
                        <Card className="sticky top-4">
                            <CardHeader>
                                <CardTitle className="text-lg">
                                    Info Konselor
                                </CardTitle>
                            </CardHeader>
                            <CardContent className="space-y-4">
                                <div className="flex items-center gap-3">
                                    <div className="relative h-12 w-12 overflow-hidden rounded-full bg-muted">
                                        <img
                                            src={photoUrl}
                                            alt={counselor.user.name}
                                            className="h-full w-full object-cover"
                                            onError={(e) => {
                                                e.currentTarget.src =
                                                    '/default-avatar.png';
                                            }}
                                        />
                                    </div>
                                    <div>
                                        <p className="font-medium">
                                            {counselor.user.name}
                                        </p>
                                        <p className="text-sm text-muted-foreground">
                                            Konselor
                                        </p>
                                    </div>
                                </div>

                                <div className="border-t pt-4">
                                    <p className="mb-3 text-sm font-medium">
                                        Pilih Durasi Sesi
                                    </p>
                                    <DurationSelector
                                        duration={durationHours}
                                        onChange={handleDurationChange}
                                        locked={lockedDuration}
                                    />
                                </div>

                                {durationHours === 2 && (
                                    <Alert>
                                        <Info className="h-4 w-4" />
                                        <AlertDescription className="text-xs">
                                            Untuk sesi 2 jam, Anda perlu memilih
                                            2 slot waktu yang berurutan.
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
                                        Pilih tanggal dan waktu baru untuk sesi
                                        konseling Anda.
                                        {durationHours === 2 &&
                                            ' Pilih 2 slot waktu yang berurutan untuk sesi 2 jam.'}
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
                                                    Tidak ada slot waktu
                                                    tersedia untuk tanggal ini.
                                                </AlertDescription>
                                            </Alert>
                                        )}
                                    </>
                                )}

                                {/* Selected Info & Button */}
                                <SelectedScheduleSummary
                                    selectedDate={selectedDate}
                                    selectedSlots={selectedSlots}
                                    durationHours={durationHours}
                                    maxSessions={maxSessions}
                                    onReset={handleReset}
                                    onConfirm={handleReschedule}
                                    isProcessing={isRescheduling}
                                />

                                {!selectedDate && (
                                    <div className="py-12 text-center">
                                        <Calendar className="mx-auto mb-3 h-12 w-12 text-muted-foreground/50" />
                                        <p className="text-sm text-muted-foreground">
                                            Pilih tanggal untuk melihat slot
                                            waktu yang tersedia
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
