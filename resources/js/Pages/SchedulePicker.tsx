import { useState, useEffect } from "react";
import { useParams, Link, useNavigate } from "react-router-dom";
import { PageLayout } from "@/components/layout/PageLayout";
import { Card, CardContent, CardHeader, CardTitle } from "@/components/ui/card";
import { Button } from "@/components/ui/button";
import { Badge } from "@/components/ui/badge";
import { Avatar, AvatarFallback, AvatarImage } from "@/components/ui/avatar";
import { SkeletonCard } from "@/components/ui/skeleton-card";
import { ChevronLeft, ChevronRight, Clock } from "lucide-react";
import { format, addDays, startOfWeek, isSameDay } from "date-fns";
import counselorsData from "@/data/counselors.json";

// Simulate some booked slots
const bookedSlots = [
  { date: "2024-12-16", time: "10:00" },
  { date: "2024-12-17", time: "14:00" },
  { date: "2024-12-18", time: "11:00" },
];

export default function SchedulePicker() {
  const { id } = useParams();
  const navigate = useNavigate();
  const [loading, setLoading] = useState(true);
  const [counselor, setCounselor] = useState<(typeof counselorsData)[0] | null>(null);
  const [weekStart, setWeekStart] = useState(startOfWeek(new Date(), { weekStartsOn: 1 }));
  const [selectedDate, setSelectedDate] = useState<Date | null>(null);
  const [selectedTime, setSelectedTime] = useState<string | null>(null);

  useEffect(() => {
    const timer = setTimeout(() => {
      const found = counselorsData.find((c) => c.id === id);
      setCounselor(found || null);
      setLoading(false);
    }, 600);
    return () => clearTimeout(timer);
  }, [id]);

  const weekDays = Array.from({ length: 7 }, (_, i) => addDays(weekStart, i));

  const getAvailableSlots = (date: Date) => {
    if (!counselor) return [];
    const dayKey = format(date, "EEEE").toLowerCase() as keyof typeof counselor.availability;
    const slots = counselor.availability[dayKey] || [];
    const dateStr = format(date, "yyyy-MM-dd");
    
    return slots.map((time) => ({
      time,
      isBooked: bookedSlots.some((b) => b.date === dateStr && b.time === time),
    }));
  };

  const handlePrevWeek = () => {
    setWeekStart(addDays(weekStart, -7));
    setSelectedDate(null);
    setSelectedTime(null);
  };

  const handleNextWeek = () => {
    setWeekStart(addDays(weekStart, 7));
    setSelectedDate(null);
    setSelectedTime(null);
  };

  const handleDateSelect = (date: Date) => {
    setSelectedDate(date);
    setSelectedTime(null);
  };

  const handleContinue = () => {
    if (selectedDate && selectedTime && counselor) {
      navigate(`/book/${counselor.id}?date=${format(selectedDate, "yyyy-MM-dd")}&time=${selectedTime}`);
    }
  };

  if (loading) {
    return (
      <PageLayout>
        <div className="max-w-3xl mx-auto">
          <SkeletonCard className="mb-6" />
          <SkeletonCard />
        </div>
      </PageLayout>
    );
  }

  if (!counselor) {
    return (
      <PageLayout>
        <div className="text-center py-12">
          <h2 className="text-xl font-semibold text-foreground">Counselor not found</h2>
          <Button asChild className="mt-4">
            <Link to="/counselors">Back to Counselors</Link>
          </Button>
        </div>
      </PageLayout>
    );
  }

  const availableSlots = selectedDate ? getAvailableSlots(selectedDate) : [];

  return (
    <PageLayout>
      <div className="max-w-3xl mx-auto">
        {/* Back Button */}
        <Button variant="ghost" asChild className="mb-4">
          <Link to={`/counselors/${id}`}>
            <ChevronLeft className="h-4 w-4 mr-1" />
            Back to Profile
          </Link>
        </Button>

        {/* Counselor Info */}
        <Card className="mb-6">
          <CardContent className="p-4">
            <div className="flex items-center gap-4">
              <Avatar className="h-14 w-14 rounded-lg">
                <AvatarImage src={counselor.photo} alt={counselor.name} />
                <AvatarFallback className="rounded-lg">
                  {counselor.name.split(" ").map((n) => n[0]).join("")}
                </AvatarFallback>
              </Avatar>
              <div>
                <h2 className="font-semibold text-foreground">{counselor.name}</h2>
                <p className="text-sm text-muted-foreground">
                  ${counselor.pricePerSession} per session
                </p>
              </div>
            </div>
          </CardContent>
        </Card>

        {/* Calendar */}
        <Card className="mb-6">
          <CardHeader className="flex-row items-center justify-between">
            <CardTitle className="text-lg">Select a Date</CardTitle>
            <div className="flex items-center gap-2">
              <Button variant="ghost" size="icon" onClick={handlePrevWeek}>
                <ChevronLeft className="h-4 w-4" />
              </Button>
              <span className="text-sm font-medium text-foreground min-w-[140px] text-center">
                {format(weekStart, "MMM d")} - {format(addDays(weekStart, 6), "MMM d, yyyy")}
              </span>
              <Button variant="ghost" size="icon" onClick={handleNextWeek}>
                <ChevronRight className="h-4 w-4" />
              </Button>
            </div>
          </CardHeader>
          <CardContent>
            <div className="grid grid-cols-7 gap-2">
              {weekDays.map((date) => {
                const slots = getAvailableSlots(date);
                const availableCount = slots.filter((s) => !s.isBooked).length;
                const isSelected = selectedDate && isSameDay(date, selectedDate);
                const isPast = date < new Date();

                return (
                  <button
                    key={date.toISOString()}
                    disabled={isPast || availableCount === 0}
                    onClick={() => handleDateSelect(date)}
                    className={`
                      p-3 rounded-lg border text-center transition-all
                      ${isSelected 
                        ? "border-primary bg-primary text-primary-foreground" 
                        : "border-border hover:border-primary/50"
                      }
                      ${(isPast || availableCount === 0) && "opacity-50 cursor-not-allowed"}
                    `}
                  >
                    <div className="text-xs font-medium opacity-70">
                      {format(date, "EEE")}
                    </div>
                    <div className="text-lg font-semibold mt-0.5">
                      {format(date, "d")}
                    </div>
                    {availableCount > 0 && (
                      <div className={`text-xs mt-1 ${isSelected ? "text-primary-foreground/80" : "text-primary"}`}>
                        {availableCount} slot{availableCount !== 1 ? "s" : ""}
                      </div>
                    )}
                  </button>
                );
              })}
            </div>
          </CardContent>
        </Card>

        {/* Time Slots */}
        {selectedDate && (
          <Card className="mb-24 animate-fade-in">
            <CardHeader>
              <CardTitle className="text-lg">
                Available Times for {format(selectedDate, "EEEE, MMMM d")}
              </CardTitle>
            </CardHeader>
            <CardContent>
              {availableSlots.length > 0 ? (
                <div className="grid grid-cols-3 sm:grid-cols-4 md:grid-cols-5 gap-2">
                  {availableSlots.map(({ time, isBooked }) => (
                    <button
                      key={time}
                      disabled={isBooked}
                      onClick={() => setSelectedTime(time)}
                      className={`
                        flex items-center justify-center gap-1.5 p-3 rounded-lg border text-sm font-medium transition-all
                        ${selectedTime === time 
                          ? "border-primary bg-primary text-primary-foreground" 
                          : "border-border hover:border-primary/50"
                        }
                        ${isBooked && "opacity-50 cursor-not-allowed bg-muted line-through"}
                      `}
                    >
                      <Clock className="h-4 w-4" />
                      {time}
                    </button>
                  ))}
                </div>
              ) : (
                <p className="text-center text-muted-foreground py-8">
                  No available slots for this day
                </p>
              )}
            </CardContent>
          </Card>
        )}

        {/* Sticky Footer */}
        {selectedDate && selectedTime && (
          <div className="fixed bottom-0 left-0 right-0 p-4 bg-card border-t shadow-lg animate-slide-up">
            <div className="container max-w-3xl mx-auto flex items-center justify-between">
              <div>
                <p className="text-sm text-muted-foreground">Selected</p>
                <p className="font-medium text-foreground">
                  {format(selectedDate, "MMM d, yyyy")} at {selectedTime}
                </p>
              </div>
              <Button size="lg" onClick={handleContinue}>
                Continue Booking
                <ChevronRight className="h-4 w-4 ml-1" />
              </Button>
            </div>
          </div>
        )}
      </div>
    </PageLayout>
  );
}
