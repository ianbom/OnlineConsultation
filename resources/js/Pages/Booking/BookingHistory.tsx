import { useState, useMemo } from "react";
import { Link } from "@inertiajs/react";
import { PageLayout } from "@/Components/layout/PageLayout";
import { Button } from "@/Components/ui/button";
import { Badge } from "@/Components/ui/badge";
import { Tabs, TabsContent, TabsList, TabsTrigger } from "@/Components/ui/tabs";
import { BookingCard } from "@/Components/bookings/BookingCard";
import { EmptyState } from "@/Components/ui/empty-state";
import { Input } from "@/Components/ui/input";
import { Select, SelectContent, SelectItem, SelectTrigger, SelectValue } from "@/Components/ui/select";
import { Calendar, Search, ArrowUpDown, Filter, X, ChevronDown } from "lucide-react";

import { Booking, Schedule } from "@/Interfaces";

type TabValue = "pending_payment" | "paid" | "completed" | "cancelled" | "rescheduled";
type SortOption = "date_asc" | "date_desc" | "name_asc" | "name_desc";

interface Props {
  bookings: Booking[];
}

export default function BookingHistory({ bookings }: Props) {
  const [activeTab, setActiveTab] = useState<TabValue>("pending_payment");
  const [searchQuery, setSearchQuery] = useState("");
  const [startDate, setStartDate] = useState("");
  const [endDate, setEndDate] = useState("");
  const [sortBy, setSortBy] = useState<SortOption>("date_desc");
  const [isFilterOpen, setIsFilterOpen] = useState(false);

  const mapStatusToCard = (status: TabValue): "completed" | "cancelled" | "upcoming" | "pending" => {
    switch (status) {
      case "pending_payment":
        return "pending";
      case "paid":
        return "upcoming";
      case "rescheduled":
        return "upcoming";
      case "completed":
        return "completed";
      case "cancelled":
        return "cancelled";
      default:
        return "pending";
    }
  };

  const getBookingDisplayStatus = (booking: Booking): TabValue => {
    switch (booking.status) {
      case "pending_payment":
        return "pending_payment";
      case "paid":
        return "paid";
      case "completed":
        return "completed";
      case "cancelled":
        return "cancelled";
      case "rescheduled":
        return "rescheduled";
      default:
        return "pending_payment";
    }
  };

  // Filter & Sort Logic
  const filteredAndSortedBookings = useMemo(() => {
    let result = bookings.filter(
      (b) => getBookingDisplayStatus(b) === activeTab
    );

    if (searchQuery.trim()) {
      result = result.filter((b) =>
        b.counselor.user.name.toLowerCase().includes(searchQuery.toLowerCase())
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
        case "date_asc":
          return new Date(a.schedule.date).getTime() - new Date(b.schedule.date).getTime();
        case "date_desc":
          return new Date(b.schedule.date).getTime() - new Date(a.schedule.date).getTime();
        case "name_asc":
          return a.counselor.user.name.localeCompare(b.counselor.user.name);
        case "name_desc":
          return b.counselor.user.name.localeCompare(a.counselor.user.name);
        default:
          return 0;
      }
    });

    return result;
  }, [bookings, activeTab, searchQuery, startDate, endDate, sortBy]);

  // Tab counts
  const tabCounts = {
    pending_payment: bookings.filter((b) => b.status === "pending_payment").length,
    paid: bookings.filter((b) => b.status === "paid").length,
    completed: bookings.filter((b) => b.status === "completed").length,
    cancelled: bookings.filter((b) => b.status === "cancelled").length,
    rescheduled: bookings.filter((b) => b.status === "rescheduled").length
  };

  const formatDateTime = (schedule: Schedule, secondSchedule?: Schedule | null) => {
    const date = new Date(schedule.date);
    const formattedDate = date.toLocaleDateString("id-ID", {
      weekday: "long",
      year: "numeric",
      month: "long",
      day: "numeric",
    });

    const startTime = schedule.start_time.substring(0, 5);
    const endTime = secondSchedule
      ? secondSchedule.end_time.substring(0, 5)
      : schedule.end_time.substring(0, 5);

    return {
      date: formattedDate,
      time: `${startTime} - ${endTime}`,
    };
  };

  const getProfilePicUrl = (profilePic: string | null) => {
    const baseUrl = import.meta.env.VITE_APP_URL;
    return profilePic ? `${baseUrl}/storage/${profilePic}` : "/default-avatar.png";
  };

  const clearFilters = () => {
    setSearchQuery("");
    setStartDate("");
    setEndDate("");
    setSortBy("date_desc");
  };

  const hasActiveFilters = searchQuery || startDate || endDate || sortBy !== "date_desc";
  const activeFilterCount = [searchQuery, startDate, endDate, sortBy !== "date_desc"].filter(Boolean).length;

  return (
    <PageLayout title="My Bookings" description="View and manage your consultation bookings">
      <Tabs
        value={activeTab}
        onValueChange={(v) => setActiveTab(v as TabValue)}
        className="mb-6"
      >
        {/* ============ SCROLLABLE TABS ============ */}
        <div className="relative mb-4">
          <div className="overflow-x-auto scrollbar-hide -mx-4 px-4 md:mx-0 md:px-0">
            <TabsList className="inline-flex w-max min-w-full md:grid md:grid-cols-5 h-auto p-1 gap-1">
              <TabsTrigger
                value="pending_payment"
                className="flex items-center justify-center gap-1.5 whitespace-nowrap px-4 py-2.5 data-[state=active]:bg-primary data-[state=active]:text-primary-foreground"
              >
                <span className="hidden sm:inline">Menunggu Pembayaran</span>
                <span className="sm:hidden">Pending</span>
                {tabCounts.pending_payment > 0 && (
                  <Badge variant="secondary" className="ml-1 h-5 min-w-[20px] px-1.5">
                    {tabCounts.pending_payment}
                  </Badge>
                )}
              </TabsTrigger>

              <TabsTrigger
                value="paid"
                className="flex items-center justify-center gap-1.5 whitespace-nowrap px-4 py-2.5 data-[state=active]:bg-primary data-[state=active]:text-primary-foreground"
              >
                Dibayar
                {tabCounts.paid > 0 && (
                  <Badge variant="secondary" className="ml-1 h-5 min-w-[20px] px-1.5">
                    {tabCounts.paid}
                  </Badge>
                )}
              </TabsTrigger>

              <TabsTrigger
                value="completed"
                className="flex items-center justify-center gap-1.5 whitespace-nowrap px-4 py-2.5 data-[state=active]:bg-primary data-[state=active]:text-primary-foreground"
              >
                Selesai
                {tabCounts.completed > 0 && (
                  <Badge variant="secondary" className="ml-1 h-5 min-w-[20px] px-1.5">
                    {tabCounts.completed}
                  </Badge>
                )}
              </TabsTrigger>

              <TabsTrigger
                value="cancelled"
                className="flex items-center justify-center gap-1.5 whitespace-nowrap px-4 py-2.5 data-[state=active]:bg-primary data-[state=active]:text-primary-foreground"
              >
                Dibatalkan
                {tabCounts.cancelled > 0 && (
                  <Badge variant="secondary" className="ml-1 h-5 min-w-[20px] px-1.5">
                    {tabCounts.cancelled}
                  </Badge>
                )}
              </TabsTrigger>

              <TabsTrigger
                value="rescheduled"
                className="flex items-center justify-center gap-1.5 whitespace-nowrap px-4 py-2.5 data-[state=active]:bg-primary data-[state=active]:text-primary-foreground"
              >
                Dijadwalkan Ulang
                {tabCounts.rescheduled > 0 && (
                  <Badge variant="secondary" className="ml-1 h-5 min-w-[20px] px-1.5">
                    {tabCounts.rescheduled}
                  </Badge>
                )}
              </TabsTrigger>
            </TabsList>
          </div>
        </div>

        {/* ============ FILTER TOGGLE BUTTON (Mobile) ============ */}
        <div className="mb-4 lg:hidden">
          <Button
            variant="outline"
            onClick={() => setIsFilterOpen(!isFilterOpen)}
            className="w-full justify-between"
          >
            <div className="flex items-center gap-2">
              <Filter className="h-4 w-4" />
              <span>Filter & Urutkan</span>
              {activeFilterCount > 0 && (
                <Badge variant="default" className="h-5 min-w-[20px] px-1.5">
                  {activeFilterCount}
                </Badge>
              )}
            </div>
            <ChevronDown className={`h-4 w-4 transition-transform ${isFilterOpen ? "rotate-180" : ""}`} />
          </Button>
        </div>

        {/* ============ FILTER SECTION ============ */}
        <div className={`bg-white rounded-lg border p-4 mb-4 space-y-4 ${isFilterOpen ? "block" : "hidden"} lg:block`}>
          {/* Header (Mobile Only) */}
          <div className="flex items-center justify-between lg:hidden pb-2 border-b">
            <h3 className="font-semibold text-base">Filter & Urutkan</h3>
            <Button
              variant="ghost"
              size="sm"
              onClick={() => setIsFilterOpen(false)}
              className="h-8 w-8 p-0"
            >
              <X className="h-4 w-4" />
            </Button>
          </div>

          {/* Filter Grid */}
          <div className="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
            {/* Search */}
            <div className="space-y-2">
              <label className="text-sm font-medium text-gray-700">Cari Konselor</label>
              <div className="relative">
                <Search className="absolute left-3 top-1/2 -translate-y-1/2 h-4 w-4 text-gray-400 pointer-events-none" />
                <Input
                  type="text"
                  placeholder="Cari nama..."
                  value={searchQuery}
                  onChange={(e) => setSearchQuery(e.target.value)}
                  className="pl-10 w-full"
                />
              </div>
            </div>

            {/* Start Date */}
            <div className="space-y-2">
              <label className="text-sm font-medium text-gray-700">Tanggal Mulai</label>
              <div className="relative">
                <Calendar className="absolute left-3 top-1/2 -translate-y-1/2 h-4 w-4 text-gray-400 pointer-events-none" />
                <Input
                  type="date"
                  value={startDate}
                  onChange={(e) => setStartDate(e.target.value)}
                  className="pl-10 w-full"
                />
              </div>
            </div>

            {/* End Date */}
            <div className="space-y-2">
              <label className="text-sm font-medium text-gray-700">Tanggal Akhir</label>
              <div className="relative">
                <Calendar className="absolute left-3 top-1/2 -translate-y-1/2 h-4 w-4 text-gray-400 pointer-events-none" />
                <Input
                  type="date"
                  value={endDate}
                  onChange={(e) => setEndDate(e.target.value)}
                  className="pl-10 w-full"
                />
              </div>
            </div>

            {/* Sort */}
            <div className="space-y-2">
              <label className="text-sm font-medium text-gray-700">Urutkan</label>
              <Select value={sortBy} onValueChange={(v) => setSortBy(v as SortOption)}>
                <SelectTrigger className="w-full">
                  <div className="flex items-center gap-2">
                    <ArrowUpDown className="h-4 w-4" />
                    <SelectValue />
                  </div>
                </SelectTrigger>
                <SelectContent>
                  <SelectItem value="date_desc">Tanggal (Terbaru)</SelectItem>
                  <SelectItem value="date_asc">Tanggal (Terlama)</SelectItem>
                  <SelectItem value="name_asc">Nama (A-Z)</SelectItem>
                  <SelectItem value="name_desc">Nama (Z-A)</SelectItem>
                </SelectContent>
              </Select>
            </div>
          </div>

          {/* Action Buttons */}
          <div className="flex flex-col sm:flex-row items-stretch sm:items-center justify-between gap-3 pt-2 border-t">
            {/* Result Count */}
            <div className="text-sm text-gray-600 text-center sm:text-left">
              Menampilkan <span className="font-semibold">{filteredAndSortedBookings.length}</span> dari{" "}
              <span className="font-semibold">
                {bookings.filter((b) => getBookingDisplayStatus(b) === activeTab).length}
              </span>{" "}
              booking
            </div>

            {/* Clear Filters */}
            {hasActiveFilters && (
              <Button
                variant="outline"
                size="sm"
                onClick={clearFilters}
                className="w-full sm:w-auto"
              >
                <X className="h-4 w-4 mr-2" />
                Reset Filter
              </Button>
            )}
          </div>
        </div>

        {/* ============ CONTENT LIST ============ */}
        <TabsContent value={activeTab} className="space-y-4 mt-0">
          {filteredAndSortedBookings.length > 0 ? (
            filteredAndSortedBookings.map((booking) => {
              const { date, time } = formatDateTime(booking.schedule, booking.second_schedule);

              return (
                <BookingCard
                  key={booking.id}
                  id={booking.id}
                  counselorName={booking.counselor.user.name}
                  counselorPhoto={getProfilePicUrl(booking.counselor.user.profile_pic)}
                  date={date}
                  time={time}
                  duration={`${booking.duration_hours} jam`}
                  status={activeTab}
                  specialization={booking.counselor.specialization}
                  paymentStatus={booking.payment?.status ?? "pending"}
                  bookingType={booking.consultation_type}
                  rescheduleStatus={booking.reschedule_status }
                  rescheduleBy={booking?.reschedule_by}


                />
              );
            })
          ) : (
            <EmptyState
              icon="calendar"
              title={hasActiveFilters ? "Tidak ada booking ditemukan" : "Tidak ada booking"}
              description={
                hasActiveFilters
                  ? "Tidak ada booking yang cocok dengan filter saat ini."
                  : "Belum ada booking dalam kategori ini."
              }
              action={
                hasActiveFilters ? (
                  <Button variant="outline" onClick={clearFilters}>
                    <X className="h-4 w-4 mr-2" />
                    Reset Filter
                  </Button>
                ) : activeTab === "cancelled" ? (
                  <Button asChild>
                    <Link href="/counselors">Cari Konselor</Link>
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
