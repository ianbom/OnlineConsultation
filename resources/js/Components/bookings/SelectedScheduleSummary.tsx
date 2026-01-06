import { Alert, AlertDescription } from '@/Components/ui/alert';
import { Button } from '@/Components/ui/button';
import { format } from 'date-fns';
import { id as idLocale } from 'date-fns/locale';
import { AlertCircle, Calendar } from 'lucide-react';

interface TimeSlot {
    id: number;
    time: string;
    startTime: string;
    endTime: string;
    isBooked: boolean;
}

interface SelectedScheduleSummaryProps {
    selectedDate: Date | null;
    selectedSlots: TimeSlot[];
    durationHours: 1 | 2;
    maxSessions: number;
    onReset: () => void;
    onConfirm: () => void;
    isProcessing: boolean;
}

export const SelectedScheduleSummary: React.FC<
    SelectedScheduleSummaryProps
> = ({
    selectedDate,
    selectedSlots,
    durationHours,
    maxSessions,
    onReset,
    onConfirm,
    isProcessing,
}) => {
    if (selectedSlots.length === 0) return null;

    return (
        <div className="space-y-3 border-t pt-4">
            <div className="space-y-2 rounded-lg bg-primary/5 p-4">
                <p className="text-sm font-medium">Jadwal Baru:</p>
                <div className="flex items-start gap-2">
                    <Calendar className="mt-0.5 h-4 w-4 text-primary" />
                    <div className="text-sm">
                        <p className="font-medium">
                            {selectedDate &&
                                format(selectedDate, 'EEEE, dd MMMM yyyy', {
                                    locale: idLocale,
                                })}
                        </p>
                        <p className="text-muted-foreground">
                            {selectedSlots[0].time} -{' '}
                            {selectedSlots[
                                selectedSlots.length - 1
                            ].endTime.substring(0, 5)}
                        </p>
                        <p className="mt-1 text-xs text-muted-foreground">
                            Durasi: {durationHours} jam
                        </p>
                    </div>
                </div>
                {maxSessions === 2 && selectedSlots.length === 1 && (
                    <Alert>
                        <AlertCircle className="h-4 w-4" />
                        <AlertDescription>
                            Pilih 1 slot lagi yang berurutan untuk sesi 2 jam.
                        </AlertDescription>
                    </Alert>
                )}
            </div>

            <div className="flex gap-3">
                <Button variant="outline" onClick={onReset} className="flex-1">
                    Reset
                </Button>
                <Button
                    onClick={onConfirm}
                    disabled={
                        isProcessing || selectedSlots.length !== durationHours
                    }
                    className="flex-1"
                >
                    {isProcessing ? 'Memproses...' : 'Konfirmasi Reschedule'}
                </Button>
            </div>
        </div>
    );
};
