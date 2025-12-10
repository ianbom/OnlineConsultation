// CalendarGrid.tsx
import { CardContent } from "@/Components/ui/card";
import { format } from "date-fns";
import { isSameDay } from "date-fns";

interface Props {
  weekDays: Date[];
  selectedDate: Date | null;
  onSelectDate: (date: Date) => void;
  getAvailableSlots: (date: Date) => any[];
}

export default function CalendarGrid({
  weekDays,
  selectedDate,
  onSelectDate,
  getAvailableSlots,
}: Props) {
  return (
    <CardContent>
      <div className="grid grid-cols-3 sm:grid-cols-5 md:grid-cols-7 gap-2">
        {weekDays.map((date) => {
          const slots = getAvailableSlots(date);
          const availableCount = slots.length;
          const isSelected = selectedDate && isSameDay(date, selectedDate);

          const today = new Date();
          today.setHours(0, 0, 0, 0);
          const isPast = date < today;

          return (
            <button
              key={date.toISOString()}
              disabled={isPast || availableCount === 0}
              onClick={() => onSelectDate(date)}
              className={`
                p-3 rounded-lg border text-center transition-all
                flex flex-col items-center justify-center
                text-xs sm:text-sm
                min-h-[60px] sm:min-h-[70px]
                ${
                  isSelected
                    ? "border-primary bg-primary text-primary-foreground"
                    : "border-border hover:border-primary/50"
                }
                ${(isPast || availableCount === 0) && "opacity-50 cursor-not-allowed"}
              `}
            >
              <div className="font-medium opacity-70">{format(date, "EEE")}</div>

              <div className="text-base sm:text-lg font-semibold mt-1">
                {format(date, "d")}
              </div>

              {availableCount > 0 && (
                <div
                  className={`mt-1 ${
                    isSelected ? "text-primary-foreground/80" : "text-primary"
                  }`}
                >
                  {availableCount} slot
                </div>
              )}
            </button>
          );
        })}
      </div>
    </CardContent>
  );
}
