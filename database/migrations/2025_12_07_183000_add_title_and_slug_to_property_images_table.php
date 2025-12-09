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
        Schema::table('property_images', function (Blueprint $table) {
            $table->string('title')->nullable()->after('property_id');
            $table->string('slug')->nullable()->after('title');
            $table->index('slug');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('property_images', function (Blueprint $table) {
            $table->dropIndex(['slug']);
            $table->dropColumn(['title', 'slug']);
        });
    }
};
