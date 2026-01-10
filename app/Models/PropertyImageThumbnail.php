<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;

class PropertyImageThumbnail extends Model
{
    protected $fillable = [
        'property_image_id',
        'size_name',
        'path',
        'width',
        'height',
        'quality',
    ];

    protected $casts = [
        'width' => 'integer',
        'height' => 'integer',
        'quality' => 'integer',
    ];

    public function image(): BelongsTo
    {
        return $this->belongsTo(PropertyImage::class, 'property_image_id');
    }

    public function getUrlAttribute(): string
    {
        return Storage::disk($this->image->disk)->url($this->path);
    }

    public function getFileSizeAttribute(): ?int
    {
        return Storage::disk($this->image->disk)->size($this->path);
    }
}