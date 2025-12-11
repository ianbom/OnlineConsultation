// import { useState, useEffect, useRef } from "react";
// import { useParams, Link } from "react-router-dom";
// import { PageLayout } from "@/components/layout/PageLayout";
// import { Card, CardContent, CardHeader, CardTitle } from "@/components/ui/card";
// import { Button } from "@/components/ui/button";
// import { Input } from "@/components/ui/input";
// import { Avatar, AvatarFallback, AvatarImage } from "@/components/ui/avatar";
// import { Badge } from "@/components/ui/badge";
// import { SkeletonCard } from "@/components/ui/skeleton-card";
// import { Send, Phone, Video, MoreVertical, ChevronLeft } from "lucide-react";
// import { format } from "date-fns";
// import bookingsData from "@/data/bookings.json";
// import chatMessagesData from "@/data/chatMessages.json";

// interface Message {
//   id: string;
//   senderId: string;
//   message: string;
//   timestamp: string;
// }

// export default function ConsultationSession() {
//   const { id } = useParams();
//   const [loading, setLoading] = useState(true);
//   const [booking, setBooking] = useState<(typeof bookingsData)[0] | null>(null);
//   const [messages, setMessages] = useState<Message[]>([]);
//   const [newMessage, setNewMessage] = useState("");
//   const [isTyping, setIsTyping] = useState(false);
//   const messagesEndRef = useRef<HTMLDivElement>(null);

//   useEffect(() => {
//     const timer = setTimeout(() => {
//       const found = bookingsData.find((b) => b.id === id);
//       setBooking(found || null);
//       setMessages(chatMessagesData);
//       setLoading(false);
//     }, 800);
//     return () => clearTimeout(timer);
//   }, [id]);

//   useEffect(() => {
//     messagesEndRef.current?.scrollIntoView({ behavior: "smooth" });
//   }, [messages]);

//   const handleSendMessage = () => {
//     if (!newMessage.trim()) return;

//     const clientMessage: Message = {
//       id: `M${Date.now()}`,
//       senderId: "client",
//       message: newMessage,
//       timestamp: new Date().toISOString(),
//     };

//     setMessages((prev) => [...prev, clientMessage]);
//     setNewMessage("");
//     setIsTyping(true);

//     // Simulate counselor typing and responding
//     setTimeout(() => {
//       setIsTyping(false);
//       const counselorMessage: Message = {
//         id: `M${Date.now() + 1}`,
//         senderId: "counselor",
//         message: "Thank you for sharing that. I understand how you feel. Let's work through this together.",
//         timestamp: new Date().toISOString(),
//       };
//       setMessages((prev) => [...prev, counselorMessage]);
//     }, 2000);
//   };

//   const handleKeyPress = (e: React.KeyboardEvent) => {
//     if (e.key === "Enter" && !e.shiftKey) {
//       e.preventDefault();
//       handleSendMessage();
//     }
//   };

//   if (loading) {
//     return (
//       <PageLayout>
//         <div className="max-w-3xl mx-auto">
//           <SkeletonCard className="mb-4" />
//           <SkeletonCard className="h-[500px]" />
//         </div>
//       </PageLayout>
//     );
//   }

//   if (!booking) {
//     return (
//       <PageLayout>
//         <div className="text-center py-12">
//           <h2 className="text-xl font-semibold text-foreground">Session not found</h2>
//           <Button asChild className="mt-4">
//             <Link to="/bookings">Back to Bookings</Link>
//           </Button>
//         </div>
//       </PageLayout>
//     );
//   }

//   return (
//     <PageLayout>
//       <div className="max-w-3xl mx-auto">
//         {/* Back Button */}
//         <Button variant="ghost" asChild className="mb-4">
//           <Link to="/bookings">
//             <ChevronLeft className="h-4 w-4 mr-1" />
//             Back to Bookings
//           </Link>
//         </Button>

//         {/* Session Header */}
//         <Card className="mb-4">
//           <CardContent className="p-4">
//             <div className="flex items-center justify-between">
//               <div className="flex items-center gap-4">
//                 <Avatar className="h-12 w-12 rounded-lg">
//                   <AvatarImage src={booking.counselorPhoto} alt={booking.counselorName} />
//                   <AvatarFallback className="rounded-lg">
//                     {booking.counselorName.split(" ").map((n) => n[0]).join("")}
//                   </AvatarFallback>
//                 </Avatar>
//                 <div>
//                   <h2 className="font-semibold text-foreground">{booking.counselorName}</h2>
//                   <div className="flex items-center gap-2 mt-0.5">
//                     <Badge variant="success" className="text-xs">In Session</Badge>
//                     <span className="text-sm text-muted-foreground">
//                       {format(new Date(booking.date), "MMM d")} • {booking.time}
//                     </span>
//                   </div>
//                 </div>
//               </div>
//               <div className="flex items-center gap-2">
//                 <Button variant="outline" size="icon">
//                   <Phone className="h-4 w-4" />
//                 </Button>
//                 <Button variant="outline" size="icon">
//                   <Video className="h-4 w-4" />
//                 </Button>
//                 <Button variant="ghost" size="icon">
//                   <MoreVertical className="h-4 w-4" />
//                 </Button>
//               </div>
//             </div>
//           </CardContent>
//         </Card>

//         {/* Chat Area */}
//         <Card className="h-[calc(100vh-320px)] min-h-[400px] flex flex-col">
//           {/* Messages */}
//           <CardContent className="flex-1 overflow-y-auto p-4 space-y-4">
//             {messages.map((message) => {
//               const isClient = message.senderId === "client";
//               return (
//                 <div
//                   key={message.id}
//                   className={`flex ${isClient ? "justify-end" : "justify-start"}`}
//                 >
//                   <div className={`flex gap-3 max-w-[80%] ${isClient ? "flex-row-reverse" : ""}`}>
//                     {!isClient && (
//                       <Avatar className="h-8 w-8 shrink-0">
//                         <AvatarImage src={booking.counselorPhoto} alt={booking.counselorName} />
//                         <AvatarFallback>
//                           {booking.counselorName.split(" ").map((n) => n[0]).join("")}
//                         </AvatarFallback>
//                       </Avatar>
//                     )}
//                     <div>
//                       <div
//                         className={`rounded-2xl px-4 py-2.5 ${
//                           isClient
//                             ? "bg-primary text-primary-foreground rounded-br-md"
//                             : "bg-secondary text-secondary-foreground rounded-bl-md"
//                         }`}
//                       >
//                         <p className="text-sm whitespace-pre-wrap">{message.message}</p>
//                       </div>
//                       <p className={`text-xs text-muted-foreground mt-1 ${isClient ? "text-right" : ""}`}>
//                         {format(new Date(message.timestamp), "h:mm a")}
//                       </p>
//                     </div>
//                   </div>
//                 </div>
//               );
//             })}

//             {/* Typing Indicator */}
//             {isTyping && (
//               <div className="flex justify-start">
//                 <div className="flex gap-3 max-w-[80%]">
//                   <Avatar className="h-8 w-8 shrink-0">
//                     <AvatarImage src={booking.counselorPhoto} alt={booking.counselorName} />
//                     <AvatarFallback>
//                       {booking.counselorName.split(" ").map((n) => n[0]).join("")}
//                     </AvatarFallback>
//                   </Avatar>
//                   <div className="bg-secondary rounded-2xl rounded-bl-md px-4 py-3">
//                     <div className="flex gap-1">
//                       <span className="h-2 w-2 rounded-full bg-muted-foreground animate-bounce" style={{ animationDelay: "0ms" }} />
//                       <span className="h-2 w-2 rounded-full bg-muted-foreground animate-bounce" style={{ animationDelay: "150ms" }} />
//                       <span className="h-2 w-2 rounded-full bg-muted-foreground animate-bounce" style={{ animationDelay: "300ms" }} />
//                     </div>
//                   </div>
//                 </div>
//               </div>
//             )}

//             <div ref={messagesEndRef} />
//           </CardContent>

//           {/* Input Area */}
//           <div className="p-4 border-t">
//             <div className="flex gap-3">
//               <Input
//                 placeholder="Type your message..."
//                 value={newMessage}
//                 onChange={(e) => setNewMessage(e.target.value)}
//                 onKeyPress={handleKeyPress}
//                 className="flex-1"
//               />
//               <Button onClick={handleSendMessage} disabled={!newMessage.trim()}>
//                 <Send className="h-4 w-4" />
//               </Button>
//             </div>
//           </div>
//         </Card>
//       </div>
//     </PageLayout>
//   );
// }
