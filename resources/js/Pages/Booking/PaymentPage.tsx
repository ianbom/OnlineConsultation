// import { useState, useEffect } from "react";
// import { useParams, useSearchParams, useNavigate, Link } from "react-router-dom";
// import { PageLayout } from "@/components/layout/PageLayout";
// import { Card, CardContent } from "@/components/ui/card";
// import { Button } from "@/components/ui/button";
// import { Badge } from "@/components/ui/badge";
// import { Loader2, CheckCircle2, Clock, XCircle } from "lucide-react";
// import { format } from "date-fns";
// import counselorsData from "@/data/counselors.json";

// type PaymentStatus = "processing" | "pending" | "paid" | "failed";

// export default function PaymentPage() {
//   const { id } = useParams();
//   const [searchParams] = useSearchParams();
//   const navigate = useNavigate();
//   const [status, setStatus] = useState<PaymentStatus>("processing");
//   const [counselor, setCounselor] = useState<(typeof counselorsData)[0] | null>(null);

//   const date = searchParams.get("date") || format(new Date(), "yyyy-MM-dd");
//   const time = searchParams.get("time") || "10:00";
//   const method = searchParams.get("method") || "card";

//   useEffect(() => {
//     const found = counselorsData.find((c) => c.id === id);
//     setCounselor(found || null);
//   }, [id]);

//   useEffect(() => {
//     // Simulate payment processing
//     const timer1 = setTimeout(() => {
//       setStatus("pending");
//     }, 2000);

//     const timer2 = setTimeout(() => {
//       // 90% success rate simulation
//       setStatus(Math.random() > 0.1 ? "paid" : "failed");
//     }, 4000);

//     return () => {
//       clearTimeout(timer1);
//       clearTimeout(timer2);
//     };
//   }, []);

//   const sessionFee = counselor?.pricePerSession || 150;
//   const serviceFee = 5;
//   const total = sessionFee + serviceFee;

//   const statusConfig = {
//     processing: {
//       icon: Loader2,
//       title: "Processing Payment",
//       description: "Redirecting to Midtrans...",
//       color: "text-info",
//       bgColor: "bg-info/10",
//       badge: "Processing",
//       badgeVariant: "info" as const,
//     },
//     pending: {
//       icon: Clock,
//       title: "Payment Pending",
//       description: "Waiting for payment confirmation...",
//       color: "text-warning",
//       bgColor: "bg-warning/10",
//       badge: "Pending",
//       badgeVariant: "warning" as const,
//     },
//     paid: {
//       icon: CheckCircle2,
//       title: "Payment Successful",
//       description: "Your booking has been confirmed!",
//       color: "text-success",
//       bgColor: "bg-success/10",
//       badge: "Paid",
//       badgeVariant: "success" as const,
//     },
//     failed: {
//       icon: XCircle,
//       title: "Payment Failed",
//       description: "Something went wrong. Please try again.",
//       color: "text-destructive",
//       bgColor: "bg-destructive/10",
//       badge: "Failed",
//       badgeVariant: "destructive" as const,
//     },
//   };

//   const config = statusConfig[status];
//   const Icon = config.icon;

//   return (
//     <PageLayout>
//       <div className="max-w-md mx-auto">
//         <Card>
//           <CardContent className="p-8 text-center">
//             {/* Status Icon */}
//             <div className={`inline-flex h-20 w-20 items-center justify-center rounded-full ${config.bgColor} mb-6`}>
//               <Icon className={`h-10 w-10 ${config.color} ${status === "processing" ? "animate-spin" : ""}`} />
//             </div>

//             {/* Status Info */}
//             <h1 className="font-display text-2xl font-semibold text-foreground mb-2">
//               {config.title}
//             </h1>
//             <p className="text-muted-foreground mb-6">{config.description}</p>

//             {/* Transaction Details */}
//             <div className="bg-muted/50 rounded-lg p-4 mb-6 text-left">
//               <div className="flex items-center justify-between mb-3">
//                 <span className="text-sm text-muted-foreground">Status</span>
//                 <Badge variant={config.badgeVariant}>{config.badge}</Badge>
//               </div>
//               <div className="space-y-2 text-sm">
//                 <div className="flex justify-between">
//                   <span className="text-muted-foreground">Transaction ID</span>
//                   <span className="font-mono text-foreground">TXN-{Date.now().toString().slice(-8)}</span>
//                 </div>
//                 <div className="flex justify-between">
//                   <span className="text-muted-foreground">Date</span>
//                   <span className="text-foreground">{format(new Date(date), "MMM d, yyyy")}</span>
//                 </div>
//                 <div className="flex justify-between">
//                   <span className="text-muted-foreground">Time</span>
//                   <span className="text-foreground">{time}</span>
//                 </div>
//                 <div className="flex justify-between pt-2 border-t mt-2">
//                   <span className="font-medium text-foreground">Total Amount</span>
//                   <span className="font-semibold text-foreground">${total.toFixed(2)}</span>
//                 </div>
//               </div>
//             </div>

//             {/* Actions */}
//             {status === "paid" && (
//               <div className="space-y-3">
//                 <Button className="w-full" size="lg" asChild>
//                   <Link to="/bookings/BK001">View Booking Details</Link>
//                 </Button>
//                 <Button variant="outline" className="w-full" asChild>
//                   <Link to="/">Back to Dashboard</Link>
//                 </Button>
//               </div>
//             )}

//             {status === "failed" && (
//               <div className="space-y-3">
//                 <Button className="w-full" size="lg" onClick={() => setStatus("processing")}>
//                   Try Again
//                 </Button>
//                 <Button variant="outline" className="w-full" asChild>
//                   <Link to={`/book/${id}?date=${date}&time=${time}`}>
//                     Change Payment Method
//                   </Link>
//                 </Button>
//               </div>
//             )}

//             {(status === "processing" || status === "pending") && (
//               <p className="text-sm text-muted-foreground animate-pulse-gentle">
//                 Please do not close this window...
//               </p>
//             )}
//           </CardContent>
//         </Card>
//       </div>
//     </PageLayout>
//   );
// }
