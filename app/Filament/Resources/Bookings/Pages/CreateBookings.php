<?php

namespace App\Filament\Resources\Bookings\Pages;

use App\Filament\Resources\Bookings\BookingsResource;
use Filament\Resources\Pages\CreateRecord;

class CreateBookings extends CreateRecord
{
    protected static string $resource = BookingsResource::class;
}
