import { useState, useEffect } from "react";
import { useParams, useSearchParams, Link, useNavigate } from "react-router-dom";
import { PageLayout } from "@/components/layout/PageLayout";
import { Card, CardContent, CardHeader, CardTitle } from "@/components/ui/card";
import { Button } from "@/components/ui/button";
import { Badge } from "@/components/ui/badge";
import { Avatar, AvatarFallback, AvatarImage } from "@/components/ui/avatar";
import { SkeletonCard } from "@/components/ui/skeleton-card";
import { Separator } from "@/components/ui/separator";
import {
  ChevronLeft,
  Calendar,
  Clock,
  CreditCard,
  Wallet,
  Building2,
  CheckCircle2,
} from "lucide-react";
import { format } from "date-fns";
import counselorsData from "@/data/counselors.json";

const paymentMethods = [
  { id: "card", name: "Credit Card", icon: CreditCard, description: "Visa, Mastercard, AMEX" },
  { id: "ewallet", name: "E-Wallet", icon: Wallet, description: "GoPay, OVO, Dana" },
  { id: "bank", name: "Bank Transfer", icon: Building2, description: "BCA, Mandiri, BNI" },
];

export default function BookingConfirmation() {
  const { id } = useParams();
  const [searchParams] = useSearchParams();
  const navigate = useNavigate();
  const [loading, setLoading] = useState(true);
  const [counselor, setCounselor] = useState<(typeof counselorsData)[0] | null>(null);
  const [selectedPayment, setSelectedPayment] = useState("card");

  const date = searchParams.get("date") || format(new Date(), "yyyy-MM-dd");
  const time = searchParams.get("time") || "10:00";

  useEffect(() => {
    const timer = setTimeout(() => {
      const found = counselorsData.find((c) => c.id === id);
      setCounselor(found || null);
      setLoading(false);
    }, 600);
    return () => clearTimeout(timer);
  }, [id]);

  const handleProceed = () => {
    navigate(`/payment/${id}?date=${date}&time=${time}&method=${selectedPayment}`);
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

  const sessionFee = counselor.pricePerSession;
  const serviceFee = 5;
  const total = sessionFee + serviceFee;

  return (
    <PageLayout>
      <div className="max-w-lg mx-auto">
        {/* Back Button */}
        <Button variant="ghost" asChild className="mb-4">
          <Link to={`/schedule/${id}`}>
            <ChevronLeft className="h-4 w-4 mr-1" />
            Back to Schedule
          </Link>
        </Button>

        <h1 className="font-display text-2xl font-semibold text-foreground mb-6">
          Confirm Your Booking
        </h1>

        {/* Booking Receipt */}
        <Card className="mb-6">
          <CardHeader className="pb-4">
            <CardTitle className="text-lg">Booking Summary</CardTitle>
          </CardHeader>
          <CardContent className="space-y-4">
            {/* Counselor Info */}
            <div className="flex items-center gap-4">
              <Avatar className="h-14 w-14 rounded-lg">
                <AvatarImage src={counselor.photo} alt={counselor.name} />
                <AvatarFallback className="rounded-lg">
                  {counselor.name.split(" ").map((n) => n[0]).join("")}
                </AvatarFallback>
              </Avatar>
              <div>
                <h3 className="font-semibold text-foreground">{counselor.name}</h3>
                <div className="flex flex-wrap gap-1 mt-1">
                  {counselor.specializations.slice(0, 2).map((spec) => (
                    <Badge key={spec} variant="secondary" className="text-xs">
                      {spec}
                    </Badge>
                  ))}
                </div>
              </div>
            </div>

            <Separator />

            {/* Date & Time */}
            <div className="space-y-3">
              <div className="flex items-center justify-between">
                <div className="flex items-center gap-2 text-muted-foreground">
                  <Calendar className="h-4 w-4" />
                  <span>Date</span>
                </div>
                <span className="font-medium text-foreground">
                  {format(new Date(date), "EEEE, MMMM d, yyyy")}
                </span>
              </div>
              <div className="flex items-center justify-between">
                <div className="flex items-center gap-2 text-muted-foreground">
                  <Clock className="h-4 w-4" />
                  <span>Time</span>
                </div>
                <span className="font-medium text-foreground">{time}</span>
              </div>
              <div className="flex items-center justify-between">
                <div className="flex items-center gap-2 text-muted-foreground">
                  <Clock className="h-4 w-4" />
                  <span>Duration</span>
                </div>
                <span className="font-medium text-foreground">60 minutes</span>
              </div>
            </div>

            <Separator />

            {/* Price Breakdown */}
            <div className="space-y-2">
              <div className="flex items-center justify-between text-sm">
                <span className="text-muted-foreground">Session Fee</span>
                <span className="text-foreground">${sessionFee.toFixed(2)}</span>
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

        {/* Payment Methods */}
        <Card className="mb-6">
          <CardHeader className="pb-4">
            <CardTitle className="text-lg">Payment Method</CardTitle>
          </CardHeader>
          <CardContent className="space-y-2">
            {paymentMethods.map((method) => {
              const isSelected = selectedPayment === method.id;
              return (
                <button
                  key={method.id}
                  onClick={() => setSelectedPayment(method.id)}
                  className={`
                    w-full flex items-center gap-4 p-4 rounded-lg border transition-all text-left
                    ${isSelected 
                      ? "border-primary bg-primary/5" 
                      : "border-border hover:border-primary/50"
                    }
                  `}
                >
                  <div className={`
                    flex h-10 w-10 items-center justify-center rounded-lg
                    ${isSelected ? "bg-primary text-primary-foreground" : "bg-muted text-muted-foreground"}
                  `}>
                    <method.icon className="h-5 w-5" />
                  </div>
                  <div className="flex-1">
                    <p className="font-medium text-foreground">{method.name}</p>
                    <p className="text-sm text-muted-foreground">{method.description}</p>
                  </div>
                  {isSelected && (
                    <CheckCircle2 className="h-5 w-5 text-primary" />
                  )}
                </button>
              );
            })}
          </CardContent>
        </Card>

        {/* Proceed Button */}
        <Button className="w-full" size="lg" onClick={handleProceed}>
          Proceed to Payment
        </Button>
      </div>
    </PageLayout>
  );
}
