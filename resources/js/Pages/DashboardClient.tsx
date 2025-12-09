import { useState, useEffect } from "react";
import { Link, usePage } from "@inertiajs/react";
import { PageLayout } from "@/Components/layout/PageLayout";
import { Card, CardContent, CardHeader, CardTitle } from "@/Components/ui/card";
import { Button } from "@/Components/ui/button";
import { Badge } from "@/Components/ui/badge";
import { BookingCard } from "@/Components/bookings/BookingCard";
import { NotificationItem } from "@/Components/notifications/NotificationItem";
import { SkeletonCard } from "@/Components/ui/skeleton-card";
import { Calendar, Clock, CreditCard, ChevronRight, Users } from "lucide-react";
import bookingsData from '../../../public/data/bookings.json';
import notificationsData from '../../../public/data/notifications.json';

export default function Dashboard() {
  const [loading, setLoading] = useState(true);
  const [bookings, setBookings] = useState<any[]>([]);
  const [notifications, setNotifications] = useState<any[]>([]);

  useEffect(() => {
    // Simulate loading
    const timer = setTimeout(() => {
      setBookings(bookingsData);
      setNotifications(notificationsData);
      setLoading(false);
    }, 800);
    return () => clearTimeout(timer);
  }, []);

  const upcomingBookings = bookings.filter((b) => b.status === "upcoming");
  const recentBookings = bookings.filter((b) => b.status === "completed").slice(0, 2);
  const pendingPayment = bookings.find((b) => b.paymentStatus === "pending");
  const unreadNotifications = notifications.filter((n) => !n.isRead);

  const stats = [
    {
      label: "Upcoming Sessions",
      value: upcomingBookings.length,
      icon: Calendar,
      color: "text-info",
      bgColor: "bg-info/10",
    },
    {
      label: "Completed Sessions",
      value: bookings.filter((b) => b.status === "completed").length,
      icon: Clock,
      color: "text-success",
      bgColor: "bg-success/10",
    },
    {
      label: "Pending Payments",
      value: bookings.filter((b) => b.paymentStatus === "pending").length,
      icon: CreditCard,
      color: "text-warning",
      bgColor: "bg-warning/10",
    },
  ];

  return (
    <PageLayout title="Welcome back, Alex" description="Here's an overview of your mental health journey">
      {/* Stats Grid */}
      <div className="grid gap-4 sm:grid-cols-3 mb-6">
        {stats.map((stat) => (
          <Card key={stat.label}>
            <CardContent className="p-4">
              <div className="flex items-center gap-4">
                <div className={`flex h-12 w-12 items-center justify-center rounded-xl ${stat.bgColor}`}>
                  <stat.icon className={`h-6 w-6 ${stat.color}`} />
                </div>
                <div>
                  <p className="text-2xl font-semibold text-foreground">{stat.value}</p>
                  <p className="text-sm text-muted-foreground">{stat.label}</p>
                </div>
              </div>
            </CardContent>
          </Card>
        ))}
      </div>

      <div className="grid gap-6 lg:grid-cols-3">
        {/* Main Content */}
        <div className="lg:col-span-2 space-y-6">
          {/* Upcoming Schedule */}
          <Card>
            <CardHeader className="flex-row items-center justify-between pb-4">
              <CardTitle className="text-lg font-nunito" >Upcoming Sessions</CardTitle>
              <Button variant="ghost" size="sm" asChild>
                <Link to="/bookings">
                  View All <ChevronRight className="h-4 w-4 ml-1" />
                </Link>
              </Button>
            </CardHeader>
            <CardContent className="space-y-3">
              {loading ? (
                <>
                  <SkeletonCard />
                  <SkeletonCard />
                </>
              ) : upcomingBookings.length > 0 ? (
                upcomingBookings.map((booking) => (
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
                <div className="text-center py-8 text-muted-foreground">
                  No upcoming sessions
                </div>
              )}
            </CardContent>
          </Card>

          {/* Recent History */}
          <Card>
            <CardHeader className="flex-row items-center justify-between pb-4">
              <CardTitle className="text-lg">Recent Consultations</CardTitle>
              <Button variant="ghost" size="sm" asChild>
                <Link to="/bookings">
                  View History <ChevronRight className="h-4 w-4 ml-1" />
                </Link>
              </Button>
            </CardHeader>
            <CardContent className="space-y-3">
              {loading ? (
                <SkeletonCard />
              ) : recentBookings.length > 0 ? (
                recentBookings.map((booking) => (
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
                <div className="text-center py-8 text-muted-foreground">
                  No recent consultations
                </div>
              )}
            </CardContent>
          </Card>
        </div>

        {/* Sidebar */}
        <div className="space-y-6">
          {/* Pending Payment */}
          {pendingPayment && (
            <Card className="border-warning/30 bg-warning/5">
              <CardContent className="p-4">
                <div className="flex items-start gap-3">
                  <div className="flex h-10 w-10 items-center justify-center rounded-full bg-warning/10">
                    <CreditCard className="h-5 w-5 text-warning" />
                  </div>
                  <div className="flex-1">
                    <h4 className="font-medium text-foreground">Payment Pending</h4>
                    <p className="text-sm text-muted-foreground mt-0.5">
                      Complete payment for your session with {pendingPayment.counselorName}
                    </p>
                    <Button variant="accent" size="sm" className="mt-3" asChild>
                      <Link to={`/bookings/${pendingPayment.id}`}>Pay Now</Link>
                    </Button>
                  </div>
                </div>
              </CardContent>
            </Card>
          )}

          {/* Notifications */}
          <Card>
            <CardHeader className="flex-row items-center justify-between pb-2">
              <CardTitle className="text-lg">Notifications</CardTitle>
              {unreadNotifications.length > 0 && (
                <Badge className="ml-2 h-5 min-w-[20px] px-1.5">{unreadNotifications.length} new</Badge>
              )}
            </CardHeader>
            <CardContent className="space-y-1 p-3">
              {loading ? (
                <div className="space-y-3">
                  {[1, 2, 3].map((i) => (
                    <div key={i} className="animate-pulse flex gap-3 p-2">
                      <div className="h-9 w-9 rounded-full bg-muted" />
                      <div className="flex-1 space-y-2">
                        <div className="h-3 w-3/4 rounded bg-muted" />
                        <div className="h-3 w-1/2 rounded bg-muted" />
                      </div>
                    </div>
                  ))}
                </div>
              ) : (
                notifications.slice(0, 4).map((notification) => (
                  <NotificationItem
                    key={notification.id}
                    type={notification.type as any}
                    title={notification.title}
                    message={notification.message}
                    timestamp={notification.timestamp}
                    isRead={notification.isRead}
                  />
                ))
              )}
            </CardContent>
          </Card>

          {/* Quick Actions */}
          <Card>
            <CardContent className="p-4">
              <h4 className="font-medium text-foreground mb-3">Quick Actions</h4>
              <div className="space-y-2">
                <Button variant="outline" className="w-full justify-start" asChild>
                  <Link to="/counselors">
                    <Users className="h-4 w-4 mr-2" />
                    Find a Counselor
                  </Link>
                </Button>
                <Button variant="outline" className="w-full justify-start" asChild>
                  <Link to="/bookings">
                    <Calendar className="h-4 w-4 mr-2" />
                    View All Bookings
                  </Link>
                </Button>
              </div>
            </CardContent>
          </Card>
        </div>
      </div>
    </PageLayout>
  );
}
