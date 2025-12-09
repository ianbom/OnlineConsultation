import { FileX, Search, Calendar, AlertCircle } from "lucide-react";
import { cn } from "@/lib/utils";

interface EmptyStateProps {
  icon?: "search" | "calendar" | "file" | "alert";
  title: string;
  description?: string;
  action?: React.ReactNode;
  className?: string;
}

const icons = {
  search: Search,
  calendar: Calendar,
  file: FileX,
  alert: AlertCircle,
};

export function EmptyState({
  icon = "file",
  title,
  description,
  action,
  className,
}: EmptyStateProps) {
  const Icon = icons[icon];

  return (
    <div
      className={cn(
        "flex flex-col items-center justify-center py-12 px-4 text-center",
        className
      )}
    >
      <div className="flex h-16 w-16 items-center justify-center rounded-full bg-muted mb-4">
        <Icon className="h-8 w-8 text-muted-foreground" />
      </div>
      <h3 className="font-display text-lg font-semibold text-foreground mb-1">
        {title}
      </h3>
      {description && (
        <p className="text-sm text-muted-foreground max-w-sm mb-4">
          {description}
        </p>
      )}
      {action}
    </div>
  );
}
