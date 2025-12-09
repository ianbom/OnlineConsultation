import { useState, useEffect } from "react";
import { useParams, Link } from "react-router-dom";
import { PageLayout } from "@/components/layout/PageLayout";
import { Card, CardContent, CardHeader, CardTitle } from "@/components/ui/card";
import { Button } from "@/components/ui/button";
import { Badge } from "@/components/ui/badge";
import { Avatar, AvatarFallback, AvatarImage } from "@/components/ui/avatar";
import { Separator } from "@/components/ui/separator";
import { SkeletonCard } from "@/components/ui/skeleton-card";
import {
  ChevronLeft,
  Calendar,
  Clock,
  CreditCard,
  ExternalLink,
  Copy,
  CheckCircle2,
} from "lucide-react";
import { format } from "date-fns";
import { useToast } from "@/hooks/use-toast";
import bookingsData from "@/data/bookings.json";

export default function BookingDetail() {
  const { id } = useParams();
  const { toast } = useToast();
  const [loading, setLoading] = useState(true);
  const [booking, setBooking] = useState<(typeof bookingsData)[0] | null>(null);
  const [copied, setCopied] = useState(false);

  useEffect(() => {
    const timer = setTimeout(() => {
      const found = bookingsData.find((b) => b.id === id);
      setBooking(found || null);
      setLoading(false);
    }, 600);
    return () => clearTimeout(timer);
  }, [id]);

  const handleCopyLink = () => {
    navigator.clipboard.writeText(`https://pay.midtrans.com/${id}`);
    setCopied(true);
    toast({
      title: "Link copied",
      description: "Payment link has been copied to clipboard",
    });
    setTimeout(() => setCopied(false), 2000);
  };

  if (loading) {
    return (
      <PageLayout>
        <div className="max-w-lg mx-auto">
          <SkeletonCard className="mb-6" />
          <SkeletonCard />
        </div>
      </PageLayout>
    );
  }

  if (!booking) {
    return (
      <PageLayout>
        <div className="text-center py-12">
          <h2 className="text-xl font-semibold text-foreground">Booking not found</h2>
          <Button asChild className="mt-4">
            <Link to="/bookings">Back to Bookings</Link>
          </Button>
        </div>
      </PageLayout>
    );
  }

  const serviceFee = 5;
  const total = booking.pricePerSession + serviceFee;

  return (
    <PageLayout>
      <div className="max-w-lg mx-auto">
        {/* Back Button */}
        <Button variant="ghost" asChild className="mb-4">
          <Link to="/bookings">
            <ChevronLeft className="h-4 w-4 mr-1" />
            Back to Bookings
          </Link>
        </Button>

        {/* Status Header */}
        <div className="flex items-center justify-between mb-6">
          <h1 className="font-display text-2xl font-semibold text-foreground">
            Booking Details
          </h1>
          <Badge variant={booking.status as any} className="text-sm">
            {booking.status}
          </Badge>
        </div>

        {/* Invoice Card */}
        <Card className="mb-6">
          <CardHeader className="pb-4">
            <div className="flex items-center justify-between">
              <CardTitle className="text-lg">Invoice #{booking.id}</CardTitle>
              <Badge variant={booking.paymentStatus === "paid" ? "success" : "warning"}>
                {booking.paymentStatus}
              </Badge>
            </div>
          </CardHeader>
          <CardContent className="space-y-4">
            {/* Counselor Info */}
            <div className="flex items-center gap-4">
              <Avatar className="h-14 w-14 rounded-lg">
                <AvatarImage src={booking.counselorPhoto} alt={booking.counselorName} />
                <AvatarFallback className="rounded-lg">
                  {booking.counselorName.split(" ").map((n) => n[0]).join("")}
                </AvatarFallback>
              </Avatar>
              <div>
                <h3 className="font-semibold text-foreground">{booking.counselorName}</h3>
                <Badge variant="secondary" className="text-xs mt-1">
                  {booking.specialization}
                </Badge>
              </div>
            </div>

            <Separator />

            {/* Session Details */}
            <div className="space-y-3">
              <div className="flex items-center justify-between">
                <div className="flex items-center gap-2 text-muted-foreground">
                  <Calendar className="h-4 w-4" />
                  <span>Date</span>
                </div>
                <span className="font-medium text-foreground">
                  {format(new Date(booking.date), "EEEE, MMMM d, yyyy")}
                </span>
              </div>
              <div className="flex items-center justify-between">
                <div className="flex items-center gap-2 text-muted-foreground">
                  <Clock className="h-4 w-4" />
                  <span>Time</span>
                </div>
                <span className="font-medium text-foreground">{booking.time}</span>
              </div>
              <div className="flex items-center justify-between">
                <div className="flex items-center gap-2 text-muted-foreground">
                  <Clock className="h-4 w-4" />
                  <span>Duration</span>
                </div>
                <span className="font-medium text-foreground">{booking.duration} minutes</span>
              </div>
              {booking.paymentMethod && (
                <div className="flex items-center justify-between">
                  <div className="flex items-center gap-2 text-muted-foreground">
                    <CreditCard className="h-4 w-4" />
                    <span>Payment Method</span>
                  </div>
                  <span className="font-medium text-foreground">{booking.paymentMethod}</span>
                </div>
              )}
            </div>

            <Separator />

            {/* Price Breakdown */}
            <div className="space-y-2">
              <div className="flex items-center justify-between text-sm">
                <span className="text-muted-foreground">Session Fee</span>
                <span className="text-foreground">${booking.pricePerSession.toFixed(2)}</span>
              </div>
              <div className="flex items-center justify-between text-sm">
                <span className="text-muted-foreground">Service Fee</span>
                <span className="text-foreground">${serviceFee.toFixed(2)}</span>
              </div>
              <Separator />
              <div className="flex items-center justify-between">
                <span className="font-semibold text-foreground">Total</span>
                <span className="text-xl font-semibold text-foreground">${total.toFixed(2)}</span>
              </div>
            </div>
          </CardContent>
        </Card>

        {/* Payment Link (for pending) */}
        {booking.paymentStatus === "pending" && (
          <Card className="mb-6 border-warning/30 bg-warning/5">
            <CardContent className="p-4">
              <h4 className="font-medium text-foreground mb-3">Payment Link</h4>
              <div className="flex items-center gap-2">
                <div className="flex-1 bg-background rounded-lg p-3 text-sm font-mono text-muted-foreground truncate">
                  https://pay.midtrans.com/{booking.id}
                </div>
                <Button variant="outline" size="icon" onClick={handleCopyLink}>
                  {copied ? (
                    <CheckCircle2 className="h-4 w-4 text-success" />
                  ) : (
                    <Copy className="h-4 w-4" />
                  )}
                </Button>
                <Button variant="outline" size="icon" asChild>
                  <a href={`https://pay.midtrans.com/${booking.id}`} target="_blank" rel="noopener noreferrer">
                    <ExternalLink className="h-4 w-4" />
                  </a>
                </Button>
              </div>
            </CardContent>
          </Card>
        )}

        {/* Actions */}
        <div className="space-y-3">
          {booking.paymentStatus === "pending" && (
            <Button className="w-full" size="lg" variant="accent" asChild>
              <Link to={`/payment/${booking.counselorId}?date=${booking.date}&time=${booking.time}`}>
                Pay Now
              </Link>
            </Button>
          )}
          {booking.status === "upcoming" && booking.paymentStatus === "paid" && (
            <Button className="w-full" size="lg" asChild>
              <Link to={`/session/${booking.id}`}>Join Session</Link>
            </Button>
          )}
          <Button variant="outline" className="w-full" asChild>
            <Link to="/bookings">View All Bookings</Link>
          </Button>
        </div>
      </div>
    </PageLayout>
  );
}
