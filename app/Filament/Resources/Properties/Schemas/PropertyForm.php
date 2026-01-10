<?php

namespace App\Filament\Resources\Properties\Schemas;

use App\Models\County;
use App\Models\SubCounty;
use App\Models\Property;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use Illuminate\Support\Facades\Storage;
use Filament\Forms\Components\Repeater;
use Filament\Schemas\Components\Section;
use Filament\Forms\Components\RichEditor;

use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Schema;

class PropertyForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->schema([
                Section::make('Basic Information')
                    ->schema([
                        TextInput::make('title')
                            ->required()
                            ->maxLength(255),
                        Select::make('type')
                            ->options([
                                'land' => 'Land',
                                'house' => 'House',
                                'apartment' => 'Apartment',
                                'commercial' => 'Commercial',
                                'industrial' => 'Industrial',
                            ])
                            ->required(),
                        RichEditor::make('description')
                            ->required()
                            ->columnSpanFull(),
                        
                    ])
                    ->columnSpanFull()
                    ->columns(2),

                Section::make('Location')
                    ->schema([
                        Select::make('county_id')
                            ->label('County')
                            ->options(fn () => \App\Models\County::pluck('county_name', 'id'))
                            ->searchable()
                            ->preload()
                            ->live()
                            ->afterStateUpdated(function (callable $set) {
                                $set('sub_county_id', null);
                                $set('ward', null);
                            }),
                        Select::make('sub_county_id')
                            ->label('Sub-County')
                            ->options(function (callable $get) {
                                 $countyId = $get('county_id');
                                 if (!$countyId) return [];
                                 return \App\Models\SubCounty::where('county_id', $countyId)
                                     ->get()
                                     ->groupBy('constituency_name')
                                     ->mapWithKeys(fn ($group) => [
                                         $group->first()->id => ucfirst($group->first()->constituency_name)
                                     ]);
                            })
                            ->searchable()
                            ->preload()
                            ->live()
                            ->afterStateUpdated(fn (callable $set) => $set('ward', null)),
                        Select::make('ward')
                             ->options(function (callable $get) {
                                        $subCountyId = $get('sub_county_id');
                                        if (!$subCountyId) return [];
                                        $subCounty = \App\Models\SubCounty::find($subCountyId);
                                        if (!$subCounty) return [];
                                        return \App\Models\SubCounty::where('constituency_name', $subCounty->constituency_name)
                                            ->pluck('ward', 'ward')
                                            ->toArray();
                                    })
                                    ->searchable()
                                    ->preload(),
                        TextInput::make('address')
                            ->maxLength(255)
                            ->nullable(),
                        TextInput::make('nearest_landmark')
                            ->maxLength(255)
                            ->nullable(),
                        TextInput::make('latitude')
                            ->numeric()
                            ->nullable()
                            ->suffix('°')
                            ->step(0.000001),
                        TextInput::make('longitude')
                            ->numeric()
                            ->nullable()
                            ->suffix('°')
                            ->step(0.000001),
                        TextInput::make('google_map_link')
                            ->url()
                            ->maxLength(500)
                            ->nullable(),
                    ])->columns(2),

                Section::make('Property Details')
                    ->schema([
                        TextInput::make('size')
                            ->numeric()
                            ->required(),
                        Select::make('size_unit')
                            ->options([
                                'sqft' => 'Square Feet',
                                'acres' => 'Acres',
                                'hectares' => 'Hectares',
                            ])
                            ->required()
                            ->default('sqft'),
                        TextInput::make('bedrooms')
                            ->numeric()
                            ->nullable(),
                        TextInput::make('bathrooms')
                            ->numeric()
                            ->nullable(),
                        TextInput::make('floors')
                            ->numeric()
                            ->default(1),
                        TextInput::make('parking_spaces')
                            ->numeric()
                            ->nullable(),
                        TextInput::make('year_built')
                            ->numeric()
                            ->nullable(),
                    ])->columns(3),

                Section::make('Property Images')
                    ->description('Upload and manage property images')
                    ->schema([
                        Repeater::make('images')
                            ->relationship('images') // Use correct relationship name
                            ->schema([
                                FileUpload::make('path')
                                    ->label('Image File')
                                    ->image()
                                    ->directory('properties/images')
                                    ->imageEditor()
                                    ->required()
                                    ->getUploadedFileNameForStorageUsing(function (TemporaryUploadedFile $file): string {
                                        $originalName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
                                        $fileName = (string) str($originalName)
                                            ->slug()
                                            ->append('-' . uniqid() . '.webp');
                                        
                                        $manager = new ImageManager(Driver::class);
                                        $image = $manager->read($file->getRealPath())
                                            ->scaleDown(1920, 1080)
                                            ->toWebp(85);
                                        
                                        // Save to storage
                                        Storage::disk('public')->put('properties/images/'.$fileName, $image);
                                        
                                        // Return the path relative to the disk root
                                        return 'properties/images/'.$fileName;
                                    })
                                    ->storeFiles(false)
                                    ->afterStateUpdated(function ($state, callable $set) {
                                        if ($state instanceof TemporaryUploadedFile) {
                                            $set('original_name', $state->getClientOriginalName());
                                            $set('mime_type', $state->getMimeType());
                                            $set('file_size', $state->getSize());
                                            $set('filename', pathinfo($state->getClientOriginalName(), PATHINFO_FILENAME));
                                            $set('disk', 'public');
                                            $set('directory', 'properties/images');
                                            $set('type', 'image');
                                        }
                                    }),
                                    
                                \Filament\Forms\Components\Hidden::make('original_name'),
                                \Filament\Forms\Components\Hidden::make('mime_type'),
                                \Filament\Forms\Components\Hidden::make('file_size'),
                                \Filament\Forms\Components\Hidden::make('filename'),
                                \Filament\Forms\Components\Hidden::make('disk'),
                                \Filament\Forms\Components\Hidden::make('directory'),
                                \Filament\Forms\Components\Hidden::make('type'),
                                    
                                    
                                TextInput::make('title')
                                    ->label('Image Title')
                                    ->required()
                                    ->maxLength(255)
                                    ->live()
                                    ->hint('A descriptive title for this image')
                                    ->afterStateUpdated(function ($state, callable $set, $get) {
                                        // Auto-generate slug when title changes
                                        if (!empty($state) && empty($get('slug'))) {
                                            $slug = str($state)->slug()->toString();
                                            $set('slug', $slug);
                                        }
                                        // Auto-fill alt text if empty
                                        if (!empty($state) && empty($get('alt_text'))) {
                                            $set('alt_text', $state);
                                        }
                                    }),
                                    
                              
                                    
                                TextInput::make('alt_text')
                                    ->label('Alt Text')
                                    ->required()
                                    ->maxLength(255)
                                    ->live()
                                    ->hint('Description for accessibility and SEO'),
                                    
                                Textarea::make('description')
                                    ->label('Image Description')
                                    ->maxLength(500)
                                    ->nullable()
                                    ->hint('Optional detailed description of this image'),
                                    
                                Toggle::make('is_featured')
                                    ->label('Set as Featured')
                                    ->default(false)
                                    ->hint('Featured image will be used as the main image')
                                    ->reactive()
                                    ->live(),
                                    
                            ])
                            ->addActionLabel('Add Image Details')
                            ->reorderable()
                            ->collapsible()
                            ->itemLabel(function (array $state): ?string {
                                return $state['title'] ?? 'New Image';
                            })
                            ->defaultItems(0)
                            ->columns(2) // Better layout for forms
                            ->columnSpan('full')
                    ])
                    ->columnSpanFull(),

                Section::make('Pricing')
                    ->schema([
                        TextInput::make('price')
                            ->numeric()
                            ->required()
                            ->prefix('KSh'),
                        TextInput::make('discounted_price')
                            ->numeric()
                            ->prefix('KSh')
                            ->nullable(),
                        Toggle::make('price_negotiable')
                            ->default(false),
                        Toggle::make('is_installment_available')
                            ->label('Installment Available')
                            ->live()
                            ->reactive()
                            ->default(false),
                        TextInput::make('deposit')
                            ->numeric()
                            ->prefix('KSh')
                            ->nullable()
                            ->live()
                            ->reactive()
                            ->visible(fn (Get $get) => $get('is_installment_available')),
                        TextInput::make('monthly_payment')
                            ->numeric()
                            ->prefix('KSh')
                            ->nullable()
                            ->live()
                            ->reactive()
                            ->visible(fn (Get $get) => $get('is_installment_available')),
                        TextInput::make('installment_months')
                            ->numeric()
                            ->nullable()
                            ->suffix('months')
                            ->live()
                            ->reactive()
                            ->visible(fn (Get $get) => $get('is_installment_available')),
                    ])->columns(2),

                Section::make('Additional Information')
                    ->schema([
                        Toggle::make('is_featured')
                            ->label('Featured Property')
                            ->default(false),
                        Toggle::make('is_verified')
                            ->label('Verified Property')
                            ->default(false),
                        Toggle::make('is_premium')
                            ->label('Premium Listing')
                            ->default(false),
                        Select::make('status')
                            ->options([
                                'available' => 'Available',
                                'sold' => 'Sold',
                                'rented' => 'Rented',
                                'under_offer' => 'Under Offer',
                                'off_market' => 'Off Market',
                            ])
                            ->default('available')
                            ->required(),
                        Select::make('listing_type')
                            ->options([
                                'sale' => 'For Sale',
                                'rent' => 'For Rent',
                                'lease' => 'For Lease',
                            ])
                            ->required()
                            ->default('sale'),
                        Textarea::make('additional_info')
                            ->label('Additional Information')
                            ->maxLength(2000)
                            ->columnSpanFull()
                            ->nullable(),
                    ])->columns(2),
            ]);
    }
}
