<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('properties', function (Blueprint $table) {
            // Primary key
            $table->id();
            
            // Basic information
            $table->string('title');
            $table->string('slug')->unique();
            $table->text('description');
            $table->enum('type', ['land', 'house', 'apartment', 'commercial', 'industrial']);
            
            // Location information
            $table->foreignId('county_id')->constrained()->onDelete('cascade');
            $table->foreignId('sub_county_id')->nullable()->constrained()->onDelete('set null');
            $table->string('ward')->nullable();
            $table->string('address')->nullable();
            $table->point('coordinates')->nullable()->comment('Latitude and longitude');
            $table->string('nearest_landmark')->nullable();
            
            // Property specifications
            $table->decimal('size', 10, 2)->comment('Size in specified unit');
            $table->enum('size_unit', ['sqft', 'acres', 'hectares', 'square_meters'])->default('sqft');
            $table->integer('bedrooms')->nullable();
            $table->integer('bathrooms')->nullable();
            $table->integer('floors')->default(1);
            $table->integer('parking_spaces')->nullable();
            $table->integer('year_built')->nullable();
            
            // Pricing
            $table->decimal('price', 15, 2);
            $table->decimal('discounted_price', 15, 2)->nullable();
            $table->boolean('price_negotiable')->default(false);
            $table->boolean('is_installment_available')->default(false);
            $table->decimal('deposit', 15, 2)->nullable();
            $table->decimal('monthly_payment', 15, 2)->nullable()->comment('If installment available');
            $table->integer('installment_months')->nullable();
            
            // Status & Flags
            $table->enum('status', ['available', 'sold', 'rented', 'under_offer', 'off_market'])->default('available');
            $table->enum('listing_type', ['sale', 'rent', 'lease'])->default('sale');
            $table->boolean('is_featured')->default(false);
            $table->boolean('is_verified')->default(false);
            $table->boolean('is_premium')->default(false);
            $table->timestamp('featured_until')->nullable();
            $table->timestamp('verified_at')->nullable();
            
            // Media & Links
            $table->string('featured_image')->nullable();
            $table->json('image_gallery')->nullable();
            $table->string('virtual_tour_link')->nullable();
            $table->string('youtube_video_link')->nullable();
            $table->string('google_map_link')->nullable();
            
            // Categorization
            $table->json('amenities')->nullable();
            $table->json('features')->nullable();
            $table->text('additional_info')->nullable();
            $table->json('tags')->nullable()->comment('Searchable tags');
            
            // SEO & Meta
            $table->string('meta_title')->nullable();
            $table->text('meta_description')->nullable();
            $table->json('meta_keywords')->nullable();
            
            // View & Performance tracking
            $table->unsignedInteger('view_count')->default(0);
            $table->unsignedInteger('contact_count')->default(0);
            $table->timestamp('last_viewed_at')->nullable();
            
            // Timestamps
            $table->timestamps();
            $table->softDeletes();
            $table->timestamp('published_at')->nullable();
            
            // Indexes for performance
            $table->index(['status', 'is_featured']);
            $table->index(['county_id', 'sub_county_id']);
            $table->index(['price', 'type']);
            $table->index(['created_at', 'published_at']);
            $table->spatialIndex('coordinates');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('properties');
    }
};