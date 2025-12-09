import { Link } from "@inertiajs/react";
import { Calendar, Clock, ChevronRight } from "lucide-react";
import { Card, CardContent } from "@/Components/ui/card";
import { Badge } from "@/Components/ui/badge";
import { Button } from "@/Components/ui/button";
import { Avatar, AvatarFallback, AvatarImage } from "@/Components/ui/avatar";
import { format } from "date-fns";

interface BookingCardProps {
  id: string;
  counselorName: string;
  counselorPhoto: string;
  date: string;
  time: string;
  duration: number;
  status: "upcoming" | "completed" | "cancelled" | "pending";
  specialization: string;
  paymentStatus?: string;
  showActions?: boolean;
}

export function BookingCard({
  id,
  counselorName,
  counselorPhoto,
  date,
  time,
  duration,
  status,
  specialization,
  paymentStatus,
  showActions = true,
}: BookingCardProps) {
  const formattedDate = format(new Date(date), "MMM d, yyyy");

  return (
    <Card>
      <CardContent className="p-4">
        <div className="flex items-start gap-4">
          <Avatar className="h-12 w-12 rounded-lg">
            <AvatarImage src={counselorPhoto} alt={counselorName} />
            <AvatarFallback className="rounded-lg">
              {counselorName.split(" ").map((n) => n[0]).join("")}
            </AvatarFallback>
          </Avatar>

          <div className="flex-1 min-w-0">
            <div className="flex items-start justify-between gap-2">
              <div>
                <h4 className="font-medium text-foreground">{counselorName}</h4>
                <p className="text-sm text-muted-foreground">{specialization}</p>
              </div>
              <Badge variant={status}>{status}</Badge>
            </div>

            <div className="flex flex-wrap items-center gap-4 mt-3 text-sm text-muted-foreground">
              <div className="flex items-center gap-1.5">
                <Calendar className="h-4 w-4" />
                <span>{formattedDate}</span>
              </div>
              <div className="flex items-center gap-1.5">
                <Clock className="h-4 w-4" />
                <span>{time} ({duration} min)</span>
              </div>
            </div>

            {showActions && (
              <div className="flex items-center gap-2 mt-3 pt-3 border-t">
                {status === "upcoming" && paymentStatus === "pending" && (
                  <Button size="sm" variant="accent" asChild>
                    <Link to={`/bookings/${id}`}>Pay Now</Link>
                  </Button>
                )}
                {status === "upcoming" && paymentStatus === "paid" && (
                  <Button size="sm" asChild>
                    <Link to={`/session/${id}`}>Join Session</Link>
                  </Button>
                )}
                <Button size="sm" variant="ghost" asChild>
                  <Link to={`/bookings/${id}`}>
                    Details
                    <ChevronRight className="h-4 w-4 ml-1" />
                  </Link>
                </Button>
              </div>
            )}
          </div>
        </div>
      </CardContent>
    </Card>
  );
}
