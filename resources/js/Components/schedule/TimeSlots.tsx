// TimeSlots.tsx
import { Card, CardContent, CardHeader, CardTitle } from '@/Components/ui/card';
import { format } from 'date-fns';
import { Clock } from 'lucide-react';

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
        <Card className="animate-fade-in mb-24">
            <CardHeader>
                <CardTitle className="text-lg">
                    Waktu Tersedia untuk {format(selectedDate, 'EEEE, d MMMM')}
                </CardTitle>
                <p className="text-sm text-muted-foreground">
                    Pilih jadwal yang Anda inginkan (Max 2 jam berdampingan)
                </p>
            </CardHeader>

            <CardContent>
                {availableSlots.length > 0 ? (
                    <div className="grid grid-cols-3 gap-2 sm:grid-cols-4 md:grid-cols-5">
                        {availableSlots.map((slot) => {
                            const isSelected = selectedSlots.some(
                                (s) => s.id === slot.id,
                            );
                            const canSelect = canSelectSlot(slot);
                            const isDisabled =
                                slot.isBooked || (!isSelected && !canSelect);

                            return (
                                <button
                                    key={slot.id}
                                    disabled={isDisabled}
                                    onClick={() => onSelectSlot(slot)}
                                    className={`flex items-center justify-center gap-1.5 rounded-lg border p-3 text-sm font-medium transition-all ${
                                        isSelected
                                            ? 'border-primary bg-primary text-primary-foreground ring-2 ring-primary ring-offset-2'
                                            : canSelect
                                              ? 'border-border hover:border-primary/50'
                                              : 'border-border'
                                    } ${isDisabled && 'cursor-not-allowed opacity-50'} ${slot.isBooked && 'bg-muted line-through'} `}
                                >
                                    <Clock className="h-4 w-4" />
                                    {slot.time}
                                </button>
                            );
                        })}
                    </div>
                ) : (
                    <p className="py-8 text-center text-muted-foreground">
                        Tidak ada jadwal tersedia di tanggal ini
                    </p>
                )}
            </CardContent>
        </Card>
    );
}
