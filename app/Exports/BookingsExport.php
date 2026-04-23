<?php

namespace App\Exports;

use App\Models\Booking;
use Illuminate\Database\Eloquent\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class BookingsExport implements FromCollection, WithHeadings, WithMapping
{
    public function __construct(
        protected Collection $bookings
    ) {
    }

    public function collection(): Collection
    {
        return $this->bookings;
    }

    public function headings(): array
    {
        return [
            'Nama Klien',
            'Nama Konselor',
            'Jadwal',
            'Durasi',
            'Status',
            'Type',
            'Harga',
            'Keluhan',
        ];
    }

    public function map($booking): array
    {
        /** @var Booking $booking */
        $startTime = substr((string) $booking->schedule?->start_time, 0, 5);
        $endTime = $booking->secondSchedule
            ? substr((string) $booking->secondSchedule->end_time, 0, 5)
            : substr((string) $booking->schedule?->end_time, 0, 5);

        $scheduleText = trim(implode(' ', array_filter([
            optional($booking->schedule?->date)->format('d-m-Y'),
            $startTime && $endTime ? "{$startTime} - {$endTime}" : null,
        ])));

        return [
            $booking->client?->name,
            $booking->counselor?->user?->name,
            $scheduleText,
            $booking->duration_hours . ' jam',
            $booking->status,
            $booking->consultation_type,
            $booking->price,
            $booking->notes,
        ];
    }
}
