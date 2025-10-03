<?php

namespace App\Filament\Resources\Bookings\Schemas;

use App\Models\Booking;
use Filament\Forms;
use Filament\Forms\Components;
use Filament\Forms\Components\DateTimePicker;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Group;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\View;
use Filament\Schemas\Schema;

class BookingsForm
{
    protected static ?string $model = Booking::class;

    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->schema([
                // Alternative approach with more styling control
                Section::make('Timeline Status')
                    ->schema([
                        View::make('filament.timeline-status')
                            ->columnSpanFull(),

                        Grid::make(5)
                            ->schema([
                                // Booked Column
                                Group::make([
                                    TextEntry::make('booked_header')
                                        ->label('Booked')

                                        ->extraAttributes(['class' => 'timeline-section-header']),
                                    DateTimePicker::make('booked_est')
                                        ->label('Est:')
                                        ->displayFormat('Y-m-d H:i:s'),
                                    // DateTimePicker::make('booked_act')
                                    //     ->label('Act:')
                                    //     ->displayFormat('Y-m-d H:i:s'),
                                ])
                                    ->columnSpan(1),

                                // Picked Up Column
                                Group::make([
                                    TextEntry::make('picked_up_header')
                                        ->label('Picked Up')

                                        ->extraAttributes(['class' => 'timeline-section-header']),
                                    DateTimePicker::make('picked_up_est')
                                        ->label('Est:')
                                        ->displayFormat('Y-m-d H:i:s'),
                                    DateTimePicker::make('picked_up_act')
                                        ->label('Act:')
                                        ->displayFormat('Y-m-d H:i:s'),
                                ])
                                    ->columnSpan(1),

                                // Departed Column
                                Group::make([
                                    TextEntry::make('departed_header')
                                        ->label('Departed')

                                        ->extraAttributes(['class' => 'timeline-section-header']),
                                    DateTimePicker::make('departed_est')
                                        ->label('Est:')
                                        ->displayFormat('Y-m-d H:i:s'),
                                    DateTimePicker::make('departed_act')
                                        ->label('Act:')
                                        ->displayFormat('Y-m-d H:i:s'),
                                ])
                                    ->columnSpan(1),

                                // Arrived Column
                                Group::make([
                                    TextEntry::make('arrived_header')
                                        ->label('Arrived')

                                        ->extraAttributes(['class' => 'timeline-section-header']),
                                    DateTimePicker::make('arrived_est')
                                        ->label('Est:')
                                        ->displayFormat('Y-m-d H:i:s'),
                                    DateTimePicker::make('arrived_act')
                                        ->label('Act:')
                                        ->displayFormat('Y-m-d H:i:s'),
                                ])
                                    ->columnSpan(1),

                                // Delivered Column
                                Group::make([
                                    TextEntry::make('delivered_header')
                                        ->label('Delivered')

                                        ->extraAttributes(['class' => 'timeline-section-header']),
                                    DateTimePicker::make('delivered')
                                        ->label('Date:')
                                        ->displayFormat('Y-m-d H:i:s'),
                                ])
                                    ->columnSpan(1),
                            ])
                    ])
                    ->columnSpanFull()
                    // ->collapsible()
                    ->extraAttributes(['class' => 'timeline-form-section']),

                Section::make('Booking Details')
                    ->schema([
                        Components\TextInput::make('shipper_name')->required(),
                        Components\TextInput::make('consignee_name')->required(),
                        Components\TextInput::make('origin_agent')->required(),
                        Components\TextInput::make('destination_agent')->required(),
                        Components\TextInput::make('booking_reference'),
                        Components\Select::make('booking_status')
                            ->options([
                                'Booked' => 'Booked',
                                'Picked Up' => 'Picked Up',
                                'Departed' => 'Departed',
                                'Arrived' => 'Arrived',
                                'Delivered' => 'Delivered',
                            ]),
                        Components\TextInput::make('lsp_carrier'),
                        Components\TextInput::make('tracking_no'),
                        Components\Select::make('mode_of_transport')
                            ->options([
                                'Ocean' => 'Ocean',
                                'Air' => 'Air',
                                'Land' => 'Land',
                            ])
                            ->required(),
                        Components\Select::make('shipment_type')
                            ->options([
                                'LCL' => 'LCL',
                                'FCL' => 'FCL',
                            ])
                            ->required(),
                        Components\TextInput::make('service_type'),
                        Components\TextInput::make('movement_type'),
                        Components\TextInput::make('number_of_containers')->numeric()->required(),
                        Components\TextInput::make('container_number')->required(),
                        Components\Radio::make('is_dg_goods')
                            ->options([
                                false => 'No',
                                true => 'Yes',
                            ])
                            ->boolean()
                            ->required(),
                        Components\Radio::make('is_reefer')
                            ->options([
                                false => 'No',
                                true => 'Yes',
                            ])
                            ->boolean()
                            ->required(),
                        Components\TextInput::make('shipper_reference_number')->required(),
                        Components\TextInput::make('house_bl')->required(),
                        Components\TextInput::make('master_bl')->required(),
                        Components\TextInput::make('gross_weight')->numeric()->required(),
                        Components\TextInput::make('hs_code')->required(),
                        Components\TextInput::make('load_reference')->required(),
                        Components\TextInput::make('place_of_receipt'),
                        Components\TextInput::make('port_of_loading'),
                        Components\TextInput::make('port_of_discharge')->required(),
                        Components\TextInput::make('place_of_delivery'),
                        Components\Textarea::make('comments'),
                    ])
                    ->columnSpanFull()
                    ->columns(4),
            ]);
    }
}
