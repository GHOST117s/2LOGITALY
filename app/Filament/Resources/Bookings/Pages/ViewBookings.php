<?php

namespace App\Filament\Resources\Bookings\Pages;

use App\Filament\Resources\Bookings\BookingsResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewBookings extends ViewRecord
{
    protected static string $resource = BookingsResource::class;
    

    protected function getHeaderActions(): array
    {

        return [
            Actions\EditAction::make(),
            Actions\DeleteAction::make(),
        ];
    }
}
