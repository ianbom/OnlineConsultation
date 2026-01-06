import { BookingCard } from '@/Components/bookings/BookingCard';
import { BookingHistoryFilters } from '@/Components/bookings/BookingHistoryFilters';
import { PageLayout } from '@/Components/layout/PageLayout';
import { Badge } from '@/Components/ui/badge';
import { Button } from '@/Components/ui/button';
import { EmptyState } from '@/Components/ui/empty-state';
import { Tabs, TabsContent, TabsList, TabsTrigger } from '@/Components/ui/tabs';
import { Booking } from '@/Interfaces';
import {
    BookingSortOption,
    BookingTabValue,
    formatScheduleDateTime,
    getBookingDisplayStatus,
    getProfilePicUrl,
} from '@/utils/booking';
import { Link } from '@inertiajs/react';
import { X } from 'lucide-react';
import { useMemo, useState } from 'react';

interface Props {
    bookings: Booking[];
}

export default function BookingHistory({ bookings }: Props) {
    const [activeTab, setActiveTab] =
        useState<BookingTabValue>('pending_payment');
    const [searchQuery, setSearchQuery] = useState('');
    const [startDate, setStartDate] = useState('');
    const [endDate, setEndDate] = useState('');
    const [sortBy, setSortBy] = useState<BookingSortOption>('date_desc');

    // Filter & Sort Logic
    const filteredAndSortedBookings = useMemo(() => {
        let result = bookings.filter(
            (b) => getBookingDisplayStatus(b.status) === activeTab,
        );

        if (searchQuery.trim()) {
            result = result.filter((b) =>
                b.counselor.user.name
                    .toLowerCase()
                    .includes(searchQuery.toLowerCase()),
            );
        }

        if (startDate) {
            result = result.filter((b) => {
                const bookingDate = new Date(b.schedule.date);
                return bookingDate >= new Date(startDate);
            });
        }
        if (endDate) {
            result = result.filter((b) => {
                const bookingDate = new Date(b.schedule.date);
                return bookingDate <= new Date(endDate);
            });
        }

        result.sort((a, b) => {
            switch (sortBy) {
                case 'date_asc':
                    return (
                        new Date(a.schedule.date).getTime() -
                        new Date(b.schedule.date).getTime()
                    );
                case 'date_desc':
                    return (
                        new Date(b.schedule.date).getTime() -
                        new Date(a.schedule.date).getTime()
                    );
                case 'name_asc':
                    return a.counselor.user.name.localeCompare(
                        b.counselor.user.name,
                    );
                case 'name_desc':
                    return b.counselor.user.name.localeCompare(
                        a.counselor.user.name,
                    );
                default:
                    return 0;
            }
        });

        return result;
    }, [bookings, activeTab, searchQuery, startDate, endDate, sortBy]);

    // Tab counts
    const tabCounts = useMemo(
        () => ({
            pending_payment: bookings.filter(
                (b) => b.status === 'pending_payment',
            ).length,
            paid: bookings.filter((b) => b.status === 'paid').length,
            completed: bookings.filter((b) => b.status === 'completed').length,
            cancelled: bookings.filter((b) => b.status === 'cancelled').length,
            rescheduled: bookings.filter((b) => b.status === 'rescheduled')
                .length,
        }),
        [bookings],
    );

    const clearFilters = () => {
        setSearchQuery('');
        setStartDate('');
        setEndDate('');
        setSortBy('date_desc');
    };

    const hasActiveFilters = Boolean(
        searchQuery || startDate || endDate || sortBy !== 'date_desc',
    );

    const totalForTab = bookings.filter(
        (b) => getBookingDisplayStatus(b.status) === activeTab,
    ).length;

    // Tab configuration for cleaner rendering
    const tabConfig = [
        {
            value: 'pending_payment' as const,
            label: 'Menunggu Pembayaran',
            shortLabel: 'Pending',
        },
        { value: 'paid' as const, label: 'Dibayar', shortLabel: 'Dibayar' },
        {
            value: 'completed' as const,
            label: 'Selesai',
            shortLabel: 'Selesai',
        },
        {
            value: 'cancelled' as const,
            label: 'Dibatalkan',
            shortLabel: 'Dibatalkan',
        },
        {
            value: 'rescheduled' as const,
            label: 'Dijadwalkan Ulang',
            shortLabel: 'Reschedule',
        },
    ];

    return (
        <PageLayout
            title="My Bookings"
            description="View and manage your consultation bookings"
        >
            <Tabs
                value={activeTab}
                onValueChange={(v) => setActiveTab(v as BookingTabValue)}
                className="mb-6"
            >
                {/* ============ SCROLLABLE TABS ============ */}
                <div className="relative mb-4">
                    <div className="scrollbar-hide -mx-4 overflow-x-auto px-4 md:mx-0 md:px-0">
                        <TabsList className="inline-flex h-auto w-max min-w-full gap-1 p-1 md:grid md:grid-cols-5">
                            {tabConfig.map((tab) => (
                                <TabsTrigger
                                    key={tab.value}
                                    value={tab.value}
                                    className="flex items-center justify-center gap-1.5 whitespace-nowrap px-4 py-2.5 data-[state=active]:bg-primary data-[state=active]:text-primary-foreground"
                                >
                                    <span className="hidden sm:inline">
                                        {tab.label}
                                    </span>
                                    <span className="sm:hidden">
                                        {tab.shortLabel}
                                    </span>
                                    {tabCounts[tab.value] > 0 && (
                                        <Badge
                                            variant="secondary"
                                            className="ml-1 h-5 min-w-[20px] px-1.5"
                                        >
                                            {tabCounts[tab.value]}
                                        </Badge>
                                    )}
                                </TabsTrigger>
                            ))}
                        </TabsList>
                    </div>
                </div>

                {/* ============ FILTER SECTION ============ */}
                <BookingHistoryFilters
                    searchQuery={searchQuery}
                    onSearchChange={setSearchQuery}
                    startDate={startDate}
                    onStartDateChange={setStartDate}
                    endDate={endDate}
                    onEndDateChange={setEndDate}
                    sortBy={sortBy}
                    onSortChange={setSortBy}
                    resultCount={filteredAndSortedBookings.length}
                    totalCount={totalForTab}
                    hasActiveFilters={hasActiveFilters}
                    onClear={clearFilters}
                />

                {/* ============ CONTENT LIST ============ */}
                <TabsContent value={activeTab} className="mt-0 space-y-4">
                    {filteredAndSortedBookings.length > 0 ? (
                        filteredAndSortedBookings.map((booking) => {
                            const { date, time } = formatScheduleDateTime(
                                booking.schedule,
                                booking.second_schedule,
                            );

                            return (
                                <BookingCard
                                    key={booking.id}
                                    id={booking.id}
                                    counselorName={booking.counselor.user.name}
                                    counselorPhoto={getProfilePicUrl(
                                        booking.counselor.user.profile_pic,
                                    )}
                                    date={date}
                                    time={time}
                                    duration={`${booking.duration_hours} jam`}
                                    status={activeTab}
                                    specialization={
                                        booking.counselor.specialization
                                    }
                                    paymentStatus={
                                        booking.payment?.status ?? 'pending'
                                    }
                                    bookingType={booking.consultation_type}
                                    rescheduleStatus={booking.reschedule_status}
                                    rescheduleBy={booking?.reschedule_by}
                                />
                            );
                        })
                    ) : (
                        <EmptyState
                            icon="calendar"
                            title={
                                hasActiveFilters
                                    ? 'Tidak ada booking ditemukan'
                                    : 'Tidak ada booking'
                            }
                            description={
                                hasActiveFilters
                                    ? 'Tidak ada booking yang cocok dengan filter saat ini.'
                                    : 'Belum ada booking dalam kategori ini.'
                            }
                            action={
                                hasActiveFilters ? (
                                    <Button
                                        variant="outline"
                                        onClick={clearFilters}
                                    >
                                        <X className="mr-2 h-4 w-4" />
                                        Reset Filter
                                    </Button>
                                ) : activeTab === 'cancelled' ? (
                                    <Button asChild>
                                        <Link href="/client/list-counselors">
                                            Cari Konselor
                                        </Link>
                                    </Button>
                                ) : undefined
                            }
                        />
                    )}
                </TabsContent>
            </Tabs>
        </PageLayout>
    );
}
