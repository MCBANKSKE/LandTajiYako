<?php

namespace App\Filament\Resources\Testimonials\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use Illuminate\Support\Facades\Storage;
use Filament\Schemas\Schema;

class TestimonialForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->required(),
                TextInput::make('role')
                    ->required(),
                TextInput::make('company')
                    ->default(null),
                Textarea::make('content')
                    ->required()
                    ->columnSpanFull(),
                FileUpload::make('image')
                    ->label('Image')
                     ->image()
                     ->directory('testimonials/images')
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
                        Storage::disk('public')->put('testimonials/images/'.$fileName, $image);
                        return $fileName;
                    })
                    ->storeFiles(false),
                TextInput::make('rating')
                    ->required()
                    ->numeric()
                    ->default(5),
                Toggle::make('is_featured')
                    ->required(),
                TextInput::make('sort_order')
                    ->required()
                    ->numeric()
                    ->default(0),
            ]);
    }
}
