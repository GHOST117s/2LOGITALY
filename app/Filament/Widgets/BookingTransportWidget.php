<?php

namespace App\Filament\Widgets;

use App\Models\Booking;
use Filament\Widgets\ChartWidget;

class BookingTransportWidget extends ChartWidget
{
    protected ?string $heading = 'Bookings by Transport Mode';

    protected function getData(): array
    {
        $modes = [
            'Ocean',
            'Air',
            'Land',
        ];

        $counts = [];
        foreach ($modes as $mode) {
            $counts[] = Booking::where('mode_of_transport', $mode)->count();
        }

        return [
            'datasets' => [
                [
                    'label' => 'Bookings',
                    'data' => $counts,
                    'backgroundColor' => [
                        '#3b82f6', // blue for Ocean
                        '#f59e42', // orange for Air
                        '#10b981', // green for Land
                    ],
                ],
            ],
            'labels' => $modes,
        ];
    }

    protected function getType(): string
    {
        return 'doughnut';
    }
}
