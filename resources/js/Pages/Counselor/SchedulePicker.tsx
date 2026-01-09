import { PageLayout } from '@/Components/layout/PageLayout';
import { Button } from '@/Components/ui/button';
import { Link, router } from '@inertiajs/react';
import { addDays, format, startOfWeek } from 'date-fns';
import { ChevronLeft, ChevronRight } from 'lucide-react';
import { useMemo, useState } from 'react';

import CalendarGrid from '@/Components/schedule/CalendarGrid';
import CalendarHeader from '@/Components/schedule/CalendarHeader';
import CounselorInfoCard from '@/Components/schedule/CounselorIndoCard';
import TimeSlots from '@/Components/schedule/TimeSlots';
import { Counselor, Schedule } from '@/Interfaces';

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
    const [weekStart, setWeekStart] = useState(
        startOfWeek(new Date(), { weekStartsOn: 1 }),
    );
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
        const dateStr = format(date, 'yyyy-MM-dd');
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
        const [h1] = time1.split(':').map(Number);
        const [h2] = time2.split(':').map(Number);
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
                a.time.localeCompare(b.time),
            );
            setSelectedSlots(newSlots);
        }
    };

    const handleContinue = () => {
        if (selectedSlots.length > 0) {
            const scheduleIds = selectedSlots.map((slot) => slot.id).join(',');
            router.visit(
                route('client.process.payment', {
                    counselorId: counselor.id,
                    scheduleIds: scheduleIds,
                }),
            );
        }
    };

    const availableSlots = selectedDate ? getAvailableSlots(selectedDate) : [];

    const profilePicUrl = counselor.user.profile_pic
        ? `/storage/${counselor.user.profile_pic}`
        : null;

    // Hitung total harga
    const totalOfflinePrice = counselor.price_per_session * selectedSlots.length;
    const totalOnlinePrice = counselor.online_price_per_session * selectedSlots.length;

    return (
        <PageLayout>
            <div className="mx-auto max-w-3xl">
                {/* Tombol Kembali */}
                <Button variant="ghost" asChild className="mb-4">
                    <Link href={route('client.counselor.show', counselor.id)}>
                        <ChevronLeft className="mr-1 h-4 w-4" />
                        Kembali ke Profil
                    </Link>
                </Button>

                {/* Informasi Konselor */}
                <CounselorInfoCard counselor={counselor} />

                <CalendarHeader
                    weekStart={weekStart}
                    onPrevWeek={() => setWeekStart(addDays(weekStart, -7))}
                    onNextWeek={() => setWeekStart(addDays(weekStart, 7))}
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
                    <TimeSlots
                        selectedDate={selectedDate}
                        availableSlots={getAvailableSlots(selectedDate)}
                        selectedSlots={selectedSlots}
                        canSelectSlot={canSelectSlot}
                        onSelectSlot={handleSlotSelect}
                    />
                )}

                {/* Footer Sticky */}
                {selectedDate && selectedSlots.length > 0 && (
                    <div className="animate-slide-up fixed bottom-0 left-0 right-0 z-50 border-t bg-card p-4 shadow-lg">
                        <div className="mx-auto flex max-w-3xl flex-col items-start justify-between gap-3 sm:flex-row sm:items-center sm:gap-0">
                            {/* Info Terpilih */}
                            <div className="w-full sm:w-auto">
                                <p className="text-sm text-muted-foreground">
                                    Terpilih
                                </p>
                                <p className="font-medium text-foreground">
                                    {format(selectedDate, 'd MMM yyyy')} •{' '}
                                    {selectedSlots
                                        .map((s) => s.time)
                                        .join(', ')}
                                </p>
                                <div className="mt-1 space-y-0.5">
                                    <p className="text-sm text-muted-foreground">
                                        Offline: Rp{' '}
                                        {totalOfflinePrice.toLocaleString('id-ID')} ({selectedSlots.length} sesi)
                                    </p>
                                    <p className="text-sm text-green-600">
                                        Online: Rp{' '}
                                        {totalOnlinePrice.toLocaleString('id-ID')} ({selectedSlots.length} sesi)
                                    </p>
                                </div>

                            </div>

                            {/* Tombol */}
                            <Button
                                size="lg"
                                onClick={handleContinue}
                                className="flex w-full items-center justify-center text-center sm:w-auto"
                            >
                                Lanjutkan Pemesanan
                                <ChevronRight className="ml-1 h-4 w-4" />
                            </Button>
                        </div>
                    </div>
                )}
            </div>
        </PageLayout>
    );
}
