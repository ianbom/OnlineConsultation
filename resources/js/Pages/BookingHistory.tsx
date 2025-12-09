import { useState, useEffect } from "react";
import { Link } from "react-router-dom";
import { PageLayout } from "@/components/layout/PageLayout";
import { Card, CardContent } from "@/components/ui/card";
import { Button } from "@/components/ui/button";
import { Badge } from "@/components/ui/badge";
import { Tabs, TabsContent, TabsList, TabsTrigger } from "@/components/ui/tabs";
import { BookingCard } from "@/components/bookings/BookingCard";
import { SkeletonList } from "@/components/ui/skeleton-card";
import { EmptyState } from "@/components/ui/empty-state";
import { Calendar, Filter } from "lucide-react";
import bookingsData from "@/data/bookings.json";

type TabValue = "upcoming" | "completed" | "cancelled";

export default function BookingHistory() {
  const [loading, setLoading] = useState(true);
  const [bookings, setBookings] = useState<typeof bookingsData>([]);
  const [activeTab, setActiveTab] = useState<TabValue>("upcoming");
  const [showFilters, setShowFilters] = useState(false);

  useEffect(() => {
    const timer = setTimeout(() => {
      setBookings(bookingsData);
      setLoading(false);
    }, 800);
    return () => clearTimeout(timer);
  }, []);

  const filteredBookings = bookings.filter((b) => b.status === activeTab);

  const tabCounts = {
    upcoming: bookings.filter((b) => b.status === "upcoming").length,
    completed: bookings.filter((b) => b.status === "completed").length,
    cancelled: bookings.filter((b) => b.status === "cancelled").length,
  };

  return (
    <PageLayout title="My Bookings" description="View and manage your consultation bookings">
      {/* Tabs */}
      <Tabs value={activeTab} onValueChange={(v) => setActiveTab(v as TabValue)} className="mb-6">
        <div className="flex items-center justify-between gap-4 mb-4">
          <TabsList className="grid w-full max-w-md grid-cols-3">
            <TabsTrigger value="upcoming" className="relative">
              Upcoming
              {tabCounts.upcoming > 0 && (
                <Badge variant="secondary" className="ml-2 h-5 min-w-[20px] px-1.5">
                  {tabCounts.upcoming}
                </Badge>
              )}
            </TabsTrigger>
            <TabsTrigger value="completed">
              Completed
              {tabCounts.completed > 0 && (
                <Badge variant="secondary" className="ml-2 h-5 min-w-[20px] px-1.5">
                  {tabCounts.completed}
                </Badge>
              )}
            </TabsTrigger>
            <TabsTrigger value="cancelled">
              Cancelled
              {tabCounts.cancelled > 0 && (
                <Badge variant="secondary" className="ml-2 h-5 min-w-[20px] px-1.5">
                  {tabCounts.cancelled}
                </Badge>
              )}
            </TabsTrigger>
          </TabsList>
        </div>

        {loading ? (
          <SkeletonList count={3} />
        ) : (
          <>
            <TabsContent value="upcoming" className="space-y-4">
              {filteredBookings.length > 0 ? (
                filteredBookings.map((booking) => (
                  <BookingCard
                    key={booking.id}
                    id={booking.id}
                    counselorName={booking.counselorName}
                    counselorPhoto={booking.counselorPhoto}
                    date={booking.date}
                    time={booking.time}
                    duration={booking.duration}
                    status={booking.status as any}
                    specialization={booking.specialization}
                    paymentStatus={booking.paymentStatus}
                  />
                ))
              ) : (
                <EmptyState
                  icon="calendar"
                  title="No upcoming bookings"
                  description="You don't have any upcoming consultations scheduled."
                  action={
                    <Button asChild>
                      <Link to="/counselors">Find a Counselor</Link>
                    </Button>
                  }
                />
              )}
            </TabsContent>

            <TabsContent value="completed" className="space-y-4">
              {filteredBookings.length > 0 ? (
                filteredBookings.map((booking) => (
                  <BookingCard
                    key={booking.id}
                    id={booking.id}
                    counselorName={booking.counselorName}
                    counselorPhoto={booking.counselorPhoto}
                    date={booking.date}
                    time={booking.time}
                    duration={booking.duration}
                    status={booking.status as any}
                    specialization={booking.specialization}
                    showActions={false}
                  />
                ))
              ) : (
                <EmptyState
                  icon="calendar"
                  title="No completed sessions"
                  description="Your completed consultation sessions will appear here."
                />
              )}
            </TabsContent>

            <TabsContent value="cancelled" className="space-y-4">
              {filteredBookings.length > 0 ? (
                filteredBookings.map((booking) => (
                  <BookingCard
                    key={booking.id}
                    id={booking.id}
                    counselorName={booking.counselorName}
                    counselorPhoto={booking.counselorPhoto}
                    date={booking.date}
                    time={booking.time}
                    duration={booking.duration}
                    status={booking.status as any}
                    specialization={booking.specialization}
                    showActions={false}
                  />
                ))
              ) : (
                <EmptyState
                  icon="calendar"
                  title="No cancelled bookings"
                  description="You haven't cancelled any bookings."
                />
              )}
            </TabsContent>
          </>
        )}
      </Tabs>
    </PageLayout>
  );
}
