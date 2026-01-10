<?php

namespace Database\Seeders;

use App\Models\Property;
use App\Models\PropertyImage;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager;

class PropertySeeder extends Seeder
{
    public function run(): void
    {
        $manager = new ImageManager(new Driver());
        
        // Create sample properties
        $properties = [
            [
                'title' => 'Modern 3-Bedroom House in Karen',
                'slug' => 'modern-3-bedroom-house-in-karen',
                'description' => '<p>A beautiful modern 3-bedroom house located in the prestigious Karen area.</p>',
                'type' => 'house',
                'county_id' => 1,
                'sub_county_id' => 1,
                'ward' => 'Karen',
                'address' => 'Karen Road, Nairobi',
                'latitude' => -1.3192,
                'longitude' => 36.7255,
                'nearest_landmark' => 'Karen Shopping Centre',
                'size' => 3500,
                'size_unit' => 'sqft',
                'bedrooms' => 3,
                'bathrooms' => 2,
                'floors' => 1,
                'parking_spaces' => 2,
                'year_built' => 2020,
                'price' => 3500000,
                'price_negotiable' => false,
                'is_installment_available' => true,
                'deposit' => 350000,
                'monthly_payment' => 15000,
                'installment_months' => 20,
                'status' => 'available',
                'listing_type' => 'sale',
                'is_featured' => true,
                'is_verified' => true,
                'is_premium' => true,
                'featured_image' => 'properties/images/property-1-1.webp',
                'published_at' => now(),
            ],
            [
                'title' => 'Prime Land in Runda',
                'slug' => 'prime-land-in-runda',
                'description' => '<p>Prime 1/4 acre plot in the prestigious Runda area.</p>',
                'type' => 'land',
                'county_id' => 1,
                'sub_county_id' => 2,
                'ward' => 'Runda',
                'address' => 'Runda Estate, Nairobi',
                'latitude' => -1.2562,
                'longitude' => 36.7955,
                'nearest_landmark' => 'Runda Mall',
                'size' => 0.25,
                'size_unit' => 'acres',
                'bedrooms' => null,
                'bathrooms' => null,
                'floors' => 0,
                'parking_spaces' => null,
                'year_built' => null,
                'price' => 5000000,
                'price_negotiable' => true,
                'is_installment_available' => false,
                'deposit' => null,
                'monthly_payment' => null,
                'installment_months' => null,
                'status' => 'available',
                'listing_type' => 'sale',
                'is_featured' => true,
                'is_verified' => true,
                'is_premium' => false,
                'featured_image' => 'properties/images/property-2-1.webp',
                'published_at' => now(),
            ],
        ];

        foreach ($properties as $propertyData) {
            $property = Property::create($propertyData);
            
            // Create 3 images for each property
            for ($i = 1; $i <= 3; $i++) {
                $image = $manager->create(800, 600)->fill('#' . str_pad(dechex($i * 80), 6, '0', STR_PAD_LEFT));
                $filename = 'property-' . $property->id . '-' . $i . '.webp';
                $path = 'properties/images/' . $filename;
                
                // Save to storage
                Storage::disk('public')->put($path, $image->toWebp(85));
                
                // Create database record
                PropertyImage::create([
                    'property_id' => $property->id,
                    'title' => 'Property Image ' . $i,
                    'slug' => 'property-image-' . $i,
                    'path' => $path,
                    'filename' => $filename,
                    'original_name' => 'property-image-' . $i . '.png',
                    'mime_type' => 'image/webp',
                    'file_size' => 50000,
                    'alt_text' => 'Property Image ' . $i,
                    'order' => $i - 1,
                    'type' => 'image',
                    'is_featured' => $i == 1,
                    'is_primary' => $i == 1,
                    'is_approved' => 1,
                    'disk' => 'public',
                    'directory' => 'properties/images',
                ]);
            }
            
            echo "Created property: {$property->title} with 3 images\n";
        }
    }
}
