<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('properties', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique()->nullable();
            $table->text('description');
            $table->enum('type', ['land', 'house', 'apartment', 'commercial', 'industrial']);
            
            // Location
            $table->foreignId('county_id')->constrained()->onDelete('cascade');
            $table->foreignId('sub_county_id')->nullable()->constrained('sub_counties')->onDelete('set null');
            $table->string('ward')->nullable();
            $table->string('address')->nullable();
            $table->string('nearest_landmark')->nullable();
            
            // Property Details
            $table->decimal('size', 10, 2)->comment('Size in square feet or acres');
            $table->string('size_unit')->default('sqft');
            $table->integer('bedrooms')->nullable();
            $table->integer('bathrooms')->nullable();
            $table->integer('floors')->default(1);
            
            // Pricing
            $table->decimal('price', 15, 2);
            $table->decimal('discounted_price', 15, 2)->nullable();
            $table->boolean('price_negotiable')->default(false);
            $table->boolean('is_installment_available')->default(false);
            $table->decimal('deposit', 15, 2)->nullable();
            
            // Status
            $table->enum('status', ['available', 'sold', 'rented', 'under_offer', 'off_market'])->default('available');
            $table->boolean('is_featured')->default(false);
            $table->boolean('is_verified')->default(false);
            
            // Media & Links
            $table->string('featured_image')->nullable();
            $table->string('youtube_video_link')->nullable();
            $table->string('google_map_link')->nullable();
            
            // Additional Details
            $table->json('amenities')->nullable();
            $table->json('features')->nullable();
            $table->text('additional_info')->nullable();
                        
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('properties');
    }
};
