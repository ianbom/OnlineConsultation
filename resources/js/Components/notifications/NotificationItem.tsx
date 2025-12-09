import { Bell, CreditCard, Info, Gift } from "lucide-react";
import { cn } from "@/lib/utils";
import { formatDistanceToNow } from "date-fns";

interface NotificationItemProps {
  type: "reminder" | "payment" | "system" | "promo";
  title: string;
  message: string;
  timestamp: string;
  isRead: boolean;
}

const typeIcons = {
  reminder: Bell,
  payment: CreditCard,
  system: Info,
  promo: Gift,
};

const typeColors = {
  reminder: "text-info bg-info/10",
  payment: "text-warning bg-warning/10",
  system: "text-muted-foreground bg-muted",
  promo: "text-accent bg-accent/10",
};

export function NotificationItem({
  type,
  title,
  message,
  timestamp,
  isRead,
}: NotificationItemProps) {
  const Icon = typeIcons[type];
  const colorClass = typeColors[type];

  return (
    <div
      className={cn(
        "flex gap-3 p-3 rounded-lg transition-colors",
        isRead ? "bg-transparent" : "bg-secondary/50"
      )}
    >
      <div className={cn("flex h-9 w-9 shrink-0 items-center justify-center rounded-full", colorClass)}>
        <Icon className="h-4 w-4" />
      </div>
      <div className="flex-1 min-w-0">
        <div className="flex items-start justify-between gap-2">
          <h4 className={cn("text-sm font-medium", !isRead && "text-foreground")}>
            {title}
          </h4>
          {!isRead && (
            <span className="h-2 w-2 rounded-full bg-primary shrink-0 mt-1.5" />
          )}
        </div>
        <p className="text-sm text-muted-foreground mt-0.5 line-clamp-2">
          {message}
        </p>
        <p className="text-xs text-muted-foreground mt-1">
          {formatDistanceToNow(new Date(timestamp), { addSuffix: true })}
        </p>
      </div>
    </div>
  );
}
