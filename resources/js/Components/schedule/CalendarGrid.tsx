// CalendarGrid.tsx
import { CardContent } from '@/Components/ui/card';
import { format, isSameDay } from 'date-fns';

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
            <div className="grid grid-cols-3 gap-2 sm:grid-cols-5 md:grid-cols-7">
                {weekDays.map((date) => {
                    const slots = getAvailableSlots(date);
                    const availableCount = slots.length;
                    const isSelected =
                        selectedDate && isSameDay(date, selectedDate);

                    const today = new Date();
                    today.setHours(0, 0, 0, 0);
                    const isPast = date < today;

                    return (
                        <button
                            key={date.toISOString()}
                            disabled={isPast || availableCount === 0}
                            onClick={() => onSelectDate(date)}
                            className={`flex min-h-[60px] flex-col items-center justify-center rounded-lg border p-3 text-center text-xs transition-all sm:min-h-[70px] sm:text-sm ${
                                isSelected
                                    ? 'border-primary bg-primary text-primary-foreground'
                                    : 'border-border hover:border-primary/50'
                            } ${(isPast || availableCount === 0) && 'cursor-not-allowed opacity-50'} `}
                        >
                            <div className="font-medium opacity-70">
                                {format(date, 'EEE')}
                            </div>

                            <div className="mt-1 text-base font-semibold sm:text-lg">
                                {format(date, 'd')}
                            </div>

                            {availableCount > 0 && (
                                <div
                                    className={`mt-1 ${
                                        isSelected
                                            ? 'text-primary-foreground/80'
                                            : 'text-primary'
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
