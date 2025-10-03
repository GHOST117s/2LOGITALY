<?php

namespace App\Filament\Widgets;

use App\Models\Booking;
use Filament\Widgets\ChartWidget;

class BookingWidget extends ChartWidget
{
    protected ?string $heading = 'Bookings by Status';

    protected function getData(): array
    {
        $statuses = [
            'Booked',
            'Picked Up',
            'Departed',
            'Arrived',
            'Delivered',
        ];

        $counts = [];
        foreach ($statuses as $status) {
            $counts[] = Booking::where('booking_status', $status)->count();
        }

        return [
            'datasets' => [
                [
                    'label' => 'Bookings',
                    'data' => $counts,
                    'backgroundColor' => [
                        '#3b82f6', // blue
                        '#f59e42', // orange
                        '#fbbf24', // yellow
                        '#10b981', // green
                        '#6366f1', // indigo
                    ],
                ],
            ],
            'labels' => $statuses,
        ];
    }

    protected function getType(): string
    {
        return 'doughnut';
    }
}
