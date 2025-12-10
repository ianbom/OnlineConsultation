// TimeSlots.tsx
import { Card, CardHeader, CardContent, CardTitle } from "@/Components/ui/card";
import { Clock } from "lucide-react";
import { format } from "date-fns";

interface TimeSlot {
  id: number;
  time: string;
  startTime: string;
  endTime: string;
  isBooked: boolean;
}

interface Props {
  selectedDate: Date;
  availableSlots: TimeSlot[];
  selectedSlots: TimeSlot[];
  canSelectSlot: (slot: TimeSlot) => boolean;
  onSelectSlot: (slot: TimeSlot) => void;
}

export default function TimeSlots({
  selectedDate,
  availableSlots,
  selectedSlots,
  canSelectSlot,
  onSelectSlot,
}: Props) {
  return (
    <Card className="mb-24 animate-fade-in">
      <CardHeader>
        <CardTitle className="text-lg">
          Waktu Tersedia untuk {format(selectedDate, "EEEE, d MMMM")}
        </CardTitle>
        <p className="text-sm text-muted-foreground">
          Pilih jadwal yang Anda inginkan
        </p>
      </CardHeader>

      <CardContent>
        {availableSlots.length > 0 ? (
          <div className="grid grid-cols-3 sm:grid-cols-4 md:grid-cols-5 gap-2">
            {availableSlots.map((slot) => {
              const isSelected = selectedSlots.some((s) => s.id === slot.id);
              const canSelect = canSelectSlot(slot);
              const isDisabled = slot.isBooked || (!isSelected && !canSelect);

              return (
                <button
                  key={slot.id}
                  disabled={isDisabled}
                  onClick={() => onSelectSlot(slot)}
                  className={`
                    flex items-center justify-center gap-1.5 p-3
                    rounded-lg border text-sm font-medium transition-all

                    ${
                      isSelected
                        ? "border-primary bg-primary text-primary-foreground ring-2 ring-primary ring-offset-2"
                        : canSelect
                        ? "border-border hover:border-primary/50"
                        : "border-border"
                    }
                    ${isDisabled && "opacity-50 cursor-not-allowed"}
                    ${slot.isBooked && "bg-muted line-through"}
                  `}
                >
                  <Clock className="h-4 w-4" />
                  {slot.time}
                </button>
              );
            })}
          </div>
        ) : (
          <p className="text-center text-muted-foreground py-8">
            Tidak ada jadwal tersedia di tanggal ini
          </p>
        )}
      </CardContent>
    </Card>
  );
}
