<?php

namespace App\Filament\Resources\Properties\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ForceDeleteBulkAction;
use Filament\Actions\RestoreBulkAction;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Table;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Filters\SelectFilter;

class PropertiesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('featuredImage.path')
                    ->label('')
                    ->getStateUsing(fn ($record) => $record->images->first()?->path)
                    ->circular()
                    ->defaultImageUrl(url('/images/placeholder.jpg'))
                    ->width(50)
                    ->height(50),
                
                TextColumn::make('title')
                    ->label('Property')
                    ->searchable()
                    ->sortable()
                    ->description(fn (Property $record) => $record->type)
                    ->wrap(),
                    
                TextColumn::make('location')
                    ->label('Location')
                    ->getStateUsing(fn (Property $record) => 
                        $record->county?->name . ', ' . $record->subCounty?->name
                    )
                    ->searchable()
                    ->sortable()
                    ->wrap(),
                    
                TextColumn::make('price')
                    ->label('Price')
                    ->money('KES')
                    ->sortable()
                    ->color('primary')
                    ->weight('bold'),
                    
                TextColumn::make('status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'available' => 'success',
                        'sold' => 'danger',
                        'rented' => 'info',
                        'under_offer' => 'warning',
                        default => 'gray',
                    })
                    ->sortable(),
                    
                ToggleColumn::make('is_featured')
                    ->label('Featured')
                    ->sortable(),
                    
                TextColumn::make('created_at')
                    ->label('Created')
                    ->dateTime('M d, Y')
                    ->sortable(),
            ])
            ->filters([
                SelectFilter::make('type')
                    ->options([
                        'land' => 'Land',
                        'house' => 'House',
                        'apartment' => 'Apartment',
                        'commercial' => 'Commercial',
                        'industrial' => 'Industrial',
                    ]),
                SelectFilter::make('status')
                    ->options([
                        'available' => 'Available',
                        'sold' => 'Sold',
                        'rented' => 'Rented',
                        'under_offer' => 'Under Offer',
                    ]),
                TrashedFilter::make(),
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                    ForceDeleteBulkAction::make(),
                    RestoreBulkAction::make(),
                ]),
            ])
            ->defaultSort('created_at', 'desc')
            ->emptyStateHeading('No properties found')
            ->emptyStateDescription('Create your first property to get started.')
            ->emptyStateIcon('heroicon-o-home')
            ->deferLoading()
            ->striped();
    }
}
