// CalendarHeader.tsx
import { Button } from '@/Components/ui/button';
import { CardHeader, CardTitle } from '@/Components/ui/card';
import { addDays, format } from 'date-fns';
import { ChevronLeft, ChevronRight } from 'lucide-react';

interface Props {
    weekStart: Date;
    onPrevWeek: () => void;
    onNextWeek: () => void;
}

export default function CalendarHeader({
    weekStart,
    onPrevWeek,
    onNextWeek,
}: Props) {
    return (
        <CardHeader className="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
            <CardTitle className="text-center text-lg sm:text-left">
                Pilih Tanggal
            </CardTitle>

            <div className="flex w-full items-center justify-center gap-2 sm:w-auto sm:justify-end">
                <Button variant="ghost" size="icon" onClick={onPrevWeek}>
                    <ChevronLeft className="h-4 w-4" />
                </Button>

                <span className="min-w-[140px] text-center text-sm font-medium text-foreground">
                    {format(weekStart, 'd MMM')} -{' '}
                    {format(addDays(weekStart, 6), 'd MMM yyyy')}
                </span>

                <Button variant="ghost" size="icon" onClick={onNextWeek}>
                    <ChevronRight className="h-4 w-4" />
                </Button>
            </div>
        </CardHeader>
    );
}
