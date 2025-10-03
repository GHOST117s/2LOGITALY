<?php

namespace App\Filament\Resources\Bookings\Tables;

use Filament\Actions\Action;
use Filament\Actions\ActionGroup;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ForceDeleteBulkAction;
use Filament\Actions\RestoreBulkAction;
use Filament\Actions\ViewAction;
use Filament\Schemas\Components\View;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Enums\RecordActionsPosition;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\Indicator;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class BookingsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('Booking_ID')->sortable()->searchable(true)->label('Booking ID'),
                TextColumn::make('booking_status')
                    ->badge()
                    ->colors([
                        'success' => 'Booked',
                        'warning' => 'Picked Up',
                        'danger' => 'Departed',
                        'primary' => 'Arrived',
                        'secondary' => 'Delivered',
                    ])
                    ->toggleable(true)
                    ->searchable()
                    ->sortable(),
                TextColumn::make('shipper_name')->sortable()->searchable(true)->toggleable(),
                TextColumn::make('consignee_name')->sortable()->searchable(true)->toggleable(),
                TextColumn::make('port_of_loading')->label('POL')->sortable()->searchable(true)->toggleable(),
                TextColumn::make('port_of_discharge')->label('POD')->sortable()->searchable(true)->toggleable(),
            ])

            ->contentGrid([
                'md' => 2,
                'xl' => 3,
            ])
            ->filters([

                TrashedFilter::make(),

                SelectFilter::make('booking_status')
                    ->options([
                        'Booked' => 'Booked',
                        'Picked Up' => 'Picked Up',
                        'Departed' => 'Departed',
                        'Arrived' => 'Arrived',
                        'Delivered' => 'Delivered',
                    ])
                    ->multiple()
                    ->label('Status'),

                SelectFilter::make('mode_of_transport')
                    ->options([
                        'Ocean' => 'Ocean',
                        'Air' => 'Air',
                        'Land' => 'Land',
                    ])
                    ->multiple()
                    ->label('Transport Mode'),

                SelectFilter::make('shipment_type')
                    ->options([
                        'FCL' => 'FCL',
                        'LCL' => 'LCL',
                    ])
                    ->label('Shipment Type'),

                Filter::make('is_dg_goods')
                    ->query(fn (Builder $query): Builder => $query->where('is_dg_goods', true))
                    ->label('Dangerous Goods Only'),

                Filter::make('is_reefer')
                    ->query(fn (Builder $query): Builder => $query->where('is_reefer', true))
                    ->label('Reefer Only'),

                Filter::make('created_at')
                    ->form([
                        DatePicker::make('created_from')
                            ->label('Created From'),
                        DatePicker::make('created_until')
                            ->label('Created Until'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['created_from'],
                                fn (Builder $query, $date): Builder => $query->whereDate('created_at', '>=', $date),
                            )
                            ->when(
                                $data['created_until'],
                                fn (Builder $query, $date): Builder => $query->whereDate('created_at', '<=', $date),
                            );
                    })
                    ->indicateUsing(function (array $data): array {
                        $indicators = [];
                        if ($data['created_from'] ?? null) {
                            $indicators[] = Indicator::make('Created from ' . \Carbon\Carbon::parse($data['created_from'])->toFormattedDateString())
                                ->removeField('created_from');
                        }
                        if ($data['created_until'] ?? null) {
                            $indicators[] = Indicator::make('Created until ' . \Carbon\Carbon::parse($data['created_until'])->toFormattedDateString())
                                ->removeField('created_until');
                        }
                        return $indicators;
                    }),

                Filter::make('delivered_date')
                    ->form([
                        DatePicker::make('delivered_from')
                            ->label('Delivered From'),
                        DatePicker::make('delivered_until')
                            ->label('Delivered Until'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['delivered_from'],
                                fn (Builder $query, $date): Builder => $query->whereDate('delivered', '>=', $date),
                            )
                            ->when(
                                $data['delivered_until'],
                                fn (Builder $query, $date): Builder => $query->whereDate('delivered', '<=', $date),
                            );
                    })
                    ->indicateUsing(function (array $data): array {
                        $indicators = [];
                        if ($data['delivered_from'] ?? null) {
                            $indicators[] = Indicator::make('Delivered from ' . \Carbon\Carbon::parse($data['delivered_from'])->toFormattedDateString())
                                ->removeField('delivered_from');
                        }
                        if ($data['delivered_until'] ?? null) {
                            $indicators[] = Indicator::make('Delivered until ' . \Carbon\Carbon::parse($data['delivered_until'])->toFormattedDateString())
                                ->removeField('delivered_until');
                        }
                        return $indicators;
                    }),

                SelectFilter::make('port_of_loading')
                    ->searchable()
                    ->multiple()
                    ->label('Port of Loading'),

                SelectFilter::make('port_of_discharge')
                    ->searchable()
                    ->multiple()
                    ->label('Port of Discharge'),
            ])
            ->recordActions([
                ActionGroup::make([]),

                EditAction::make()->label('Edit'),
                ViewAction::make()->label('View'),
            ],position: RecordActionsPosition::BeforeColumns)
            // ->headerActions([
            //      Action::make('toggleView')
            //          ->label('Toggle View')
            //         //  ->icon('heroicon-s-view')
            //          ->action(function(){
            //             dd('Toggle View Clicked');
            //          })
            // ])
            ->toolbarActions([
                // BulkActionGroup::make([
                //     DeleteBulkAction::make(),
                //     ForceDeleteBulkAction::make(),
                //     RestoreBulkAction::make(),
                // ]),
            ]);
    }
}
