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
import { Calendar, Search, ArrowUpDown } from "lucide-react";

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

  // -------------------------------
  // Filter & Sort Logic
  // -------------------------------
  const filteredAndSortedBookings = useMemo(() => {
    let result = bookings.filter(
      (b) => getBookingDisplayStatus(b) === activeTab
    );

    // Filter by counselor name
    if (searchQuery.trim()) {
      result = result.filter((b) =>
        b.counselor.user.name.toLowerCase().includes(searchQuery.toLowerCase())
      );
    }

    // Filter by date range
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

    // Sorting
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

  // -------------------------------
  // Tab counts
  // -------------------------------
  const tabCounts = {
    pending_payment: bookings.filter((b) => b.status === "pending_payment").length,
    paid: bookings.filter((b) => b.status === "paid").length,
    completed: bookings.filter((b) => b.status === "completed").length,
    cancelled: bookings.filter((b) => b.status === "cancelled").length,
    rescheduled: bookings.filter((b) => b.status === "rescheduled").length
  };

  // -------------------------------
  // Format date & time
  // -------------------------------
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

  // Clear all filters
  const clearFilters = () => {
    setSearchQuery("");
    setStartDate("");
    setEndDate("");
    setSortBy("date_desc");
  };

  const hasActiveFilters = searchQuery || startDate || endDate || sortBy !== "date_desc";

  return (
    <PageLayout title="My Bookings" description="View and manage your consultation bookings">
      <Tabs
        value={activeTab}
        onValueChange={(v) => setActiveTab(v as TabValue)}
        className="mb-6"
      >
        <div className="flex items-center justify-between gap-4 mb-4">
          <TabsList className="grid w-full max-w-3xl grid-cols-5">

            <TabsTrigger value="pending_payment">
              Pending
              {tabCounts.pending_payment > 0 && (
                <Badge variant="secondary" className="ml-2">{tabCounts.pending_payment}</Badge>
              )}
            </TabsTrigger>

            <TabsTrigger value="paid">
              Paid
              {tabCounts.paid > 0 && (
                <Badge variant="secondary" className="ml-2">{tabCounts.paid}</Badge>
              )}
            </TabsTrigger>

            <TabsTrigger value="completed">
              Completed
              {tabCounts.completed > 0 && (
                <Badge variant="secondary" className="ml-2">{tabCounts.completed}</Badge>
              )}
            </TabsTrigger>

            <TabsTrigger value="cancelled">
              Cancelled
              {tabCounts.cancelled > 0 && (
                <Badge variant="secondary" className="ml-2">{tabCounts.cancelled}</Badge>
              )}
            </TabsTrigger>

            <TabsTrigger value="rescheduled">
              Rescheduled
              {tabCounts.rescheduled > 0 && (
                <Badge variant="secondary" className="ml-2">{tabCounts.rescheduled}</Badge>
              )}
            </TabsTrigger>

          </TabsList>
        </div>

        {/* FILTER & SORTING SECTION */}
        <div className="bg-white rounded-lg border p-4 mb-4 space-y-4">
          <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">

            {/* Search by Counselor Name */}
            <div className="space-y-2">
              <label className="text-sm font-medium text-gray-700">
                Search Counselor
              </label>
              <div className="relative">
                <Search className="absolute left-3 top-1/2 transform -translate-y-1/2 h-4 w-4 text-gray-400" />
                <Input
                  type="text"
                  placeholder="Search by name..."
                  value={searchQuery}
                  onChange={(e) => setSearchQuery(e.target.value)}
                  className="pl-10"
                />
              </div>
            </div>

            {/* Start Date Filter */}
            <div className="space-y-2">
              <label className="text-sm font-medium text-gray-700">
                Start Date
              </label>
              <div className="relative">
                <Calendar className="absolute left-3 top-1/2 transform -translate-y-1/2 h-4 w-4 text-gray-400" />
                <Input
                  type="date"
                  value={startDate}
                  onChange={(e) => setStartDate(e.target.value)}
                  className="pl-10"
                />
              </div>
            </div>

            {/* End Date Filter */}
            <div className="space-y-2">
              <label className="text-sm font-medium text-gray-700">
                End Date
              </label>
              <div className="relative">
                <Calendar className="absolute left-3 top-1/2 transform -translate-y-1/2 h-4 w-4 text-gray-400" />
                <Input
                  type="date"
                  value={endDate}
                  onChange={(e) => setEndDate(e.target.value)}
                  className="pl-10"
                />
              </div>
            </div>

            {/* Sort By */}
            <div className="space-y-2">
              <label className="text-sm font-medium text-gray-700">
                Sort By
              </label>
              <Select value={sortBy} onValueChange={(v) => setSortBy(v as SortOption)}>
                <SelectTrigger>
                  <div className="flex items-center gap-2">
                    <ArrowUpDown className="h-4 w-4" />
                    <SelectValue />
                  </div>
                </SelectTrigger>
                <SelectContent>
                  <SelectItem value="date_desc">Date (Newest First)</SelectItem>
                  <SelectItem value="date_asc">Date (Oldest First)</SelectItem>
                  <SelectItem value="name_asc">Name (A-Z)</SelectItem>
                  <SelectItem value="name_desc">Name (Z-A)</SelectItem>
                </SelectContent>
              </Select>
            </div>

          </div>

          {/* Clear Filters Button */}
          {hasActiveFilters && (
            <div className="flex justify-end">
              <Button
                variant="outline"
                size="sm"
                onClick={clearFilters}
              >
                Clear All Filters
              </Button>
            </div>
          )}

          {/* Results Count */}
          <div className="text-sm text-gray-600">
            Showing {filteredAndSortedBookings.length} of {bookings.filter((b) => getBookingDisplayStatus(b) === activeTab).length} bookings
          </div>
        </div>

        {/* RENDER CONTENT BERDASARKAN TAB */}
        <TabsContent value={activeTab} className="space-y-4">
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
                  duration={`${booking.duration_hours} hour${booking.duration_hours > 1 ? "s" : ""}`}
                  status={activeTab}
                  specialization={booking.counselor.specialization}
                  paymentStatus={booking.payment?.status ?? "pending"}
                />
              );
            })
          ) : (
            <EmptyState
              icon="calendar"
              title={hasActiveFilters ? "No bookings found" : "No bookings"}
              description={
                hasActiveFilters
                  ? "No bookings match your current filters. Try adjusting your search criteria."
                  : "There are no bookings in this category."
              }
              action={
                hasActiveFilters ? (
                  <Button variant="outline" onClick={clearFilters}>
                    Clear Filters
                  </Button>
                ) : activeTab === "cancelled" ? (
                  <Button asChild>
                    <Link href="/counselors">Find a Counselor</Link>
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
