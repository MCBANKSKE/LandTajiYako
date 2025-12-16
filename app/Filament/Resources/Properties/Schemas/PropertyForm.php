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
                        TextInput::make('slug')
                            ->maxLength(255)
                            ->unique(Property::class, 'slug', ignoreRecord: true),
                        RichEditor::make('description')
                            ->required()
                            ->columnSpanFull(),
                        Select::make('type')
                            ->options([
                                'land' => 'Land',
                                'house' => 'House',
                                'apartment' => 'Apartment',
                                'commercial' => 'Commercial',
                                'industrial' => 'Industrial',
                            ])
                            ->required(),
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
                                $set('subcounty_id', null);
                                $set('ward', null);
                            }),
                        Select::make('sub_county_id')
                            ->label('Sub-County')
                            ->options(function (callable $get) {
                                 $countyId = $get('county_id');
                                 if (!$countyId) return [];
                                 return \App\Models\SubCounty::where('county_id', $countyId)
                                 ->get()
                                 ->unique('constituency_name')
                                 ->mapWithKeys(fn ($sub) => [$sub->id => ucfirst($sub->constituency_name)]);
                            })
                            ->searchable()
                            ->preload()
                            ->live()
                            ->afterStateUpdated(fn (callable $set) => $set('ward', null)),
                        Select::make('ward')
                             ->options(function (callable $get) {
                                        $subCountyId = $get('subcounty_id');
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
                    ])->columns(3),

                Section::make('Property Images')
                    ->description('Upload and manage property images')
                    ->schema([
                        Repeater::make('propertyImages')
                            ->relationship('propertyImages') // Explicitly specify relationship name
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
                                        return $fileName;
                                    })
                                    ->storeFiles(false),
                                    
                                    
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
                                    
                                TextInput::make('slug')
                                    ->label('URL Slug')
                                    ->maxLength(255)
                                    ->hint('Auto-generated from title')
                                    ->unique('property_images', 'slug', ignoreRecord: true)
                                    ->dehydrated(),
                                    
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
                    ])->columns(2),


                Section::make('Additional Information')
                    ->schema([
                        Toggle::make('is_featured')
                            ->label('Featured Property')
                            ->default(false),
                        Toggle::make('is_verified')
                            ->label('Verified Property')
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
                        Textarea::make('additional_info')
                            ->label('Additional Information')
                            ->maxLength(2000)
                            ->columnSpanFull()
                            ->nullable(),
                    ])->columns(2),
            ]);
    }
}
