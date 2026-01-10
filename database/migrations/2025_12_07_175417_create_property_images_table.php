<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('property_images', function (Blueprint $table) {
            $table->id();
            $table->foreignId('property_id')
                ->constrained()
                ->onDelete('cascade')
                ->onUpdate('cascade');
            
            // Image details
            $table->string('title')->nullable();
            $table->string('slug')->nullable();
            $table->string('path');
            $table->string('filename');
            $table->string('original_name');
            $table->string('mime_type');
            $table->unsignedInteger('file_size')->comment('Size in bytes');
            
            // Image metadata
            $table->string('alt_text')->nullable();
            $table->text('caption')->nullable();
            $table->text('description')->nullable();
            
            // Display & ordering
            $table->integer('order')->default(0);
            $table->enum('type', ['image', 'floor_plan', 'document', 'video_thumbnail'])->default('image');
            $table->boolean('is_featured')->default(false);
            $table->boolean('is_primary')->default(false);
            $table->boolean('is_approved')->default(true);
            
            // Image dimensions
            $table->unsignedInteger('width')->nullable();
            $table->unsignedInteger('height')->nullable();
            
            // Storage info
            $table->string('disk')->default('public');
            $table->string('directory')->default('properties/images');
            
            // Timestamps
            $table->timestamps();
            $table->softDeletes();
            
            // Indexes for performance
            $table->index(['property_id', 'is_featured']);
            $table->index(['property_id', 'type']);
            $table->index(['property_id', 'order']);
            $table->unique(['property_id', 'slug']);
            $table->index('slug');
        });
        
        // Create thumbnails table for different image sizes
        Schema::create('property_image_thumbnails', function (Blueprint $table) {
            $table->id();
            $table->foreignId('property_image_id')
                ->constrained()
                ->onDelete('cascade');
            
            $table->string('size_name')->comment('e.g., thumbnail, medium, large');
            $table->string('path');
            $table->unsignedInteger('width');
            $table->unsignedInteger('height');
            $table->unsignedInteger('quality')->default(85);
            
            $table->timestamps();
            
            $table->unique(['property_image_id', 'size_name']);
            $table->index(['property_image_id', 'size_name']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('property_image_thumbnails');
        Schema::dropIfExists('property_images');
    }
};