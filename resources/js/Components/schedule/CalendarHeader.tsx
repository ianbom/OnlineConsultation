// CalendarHeader.tsx
import { CardHeader, CardTitle } from "@/Components/ui/card";
import { Button } from "@/Components/ui/button";
import { ChevronLeft, ChevronRight } from "lucide-react";
import { format, addDays } from "date-fns";

interface Props {
  weekStart: Date;
  onPrevWeek: () => void;
  onNextWeek: () => void;
}

export default function CalendarHeader({ weekStart, onPrevWeek, onNextWeek }: Props) {
  return (
    <CardHeader className="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
      <CardTitle className="text-lg text-center sm:text-left">
        Pilih Tanggal
      </CardTitle>

      <div className="flex items-center justify-center sm:justify-end gap-2 w-full sm:w-auto">
        <Button variant="ghost" size="icon" onClick={onPrevWeek}>
          <ChevronLeft className="h-4 w-4" />
        </Button>

        <span className="text-sm font-medium text-foreground min-w-[140px] text-center">
          {format(weekStart, "d MMM")} - {format(addDays(weekStart, 6), "d MMM yyyy")}
        </span>

        <Button variant="ghost" size="icon" onClick={onNextWeek}>
          <ChevronRight className="h-4 w-4" />
        </Button>
      </div>
    </CardHeader>
  );
}
