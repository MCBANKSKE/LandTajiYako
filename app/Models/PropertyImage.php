<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PropertyImage extends Model
{
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'property_id',
        'title',
        'slug',
        'path',
        'alt_text',
        'order',
        'is_featured',
        'description',
    ];
    
    /**
     * Boot the model.
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->slug) && !empty($model->title)) {
                $model->slug = \Illuminate\Support\Str::slug($model->title);
            }
        });

        static::updating(function ($model) {
            if (empty($model->slug) && !empty($model->title)) {
                $model->slug = \Illuminate\Support\Str::slug($model->title);
            }
        });
    }

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'order' => 'integer',
        'is_featured' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array<int, string>
     */
    protected $appends = [
        'url',
        'thumbnail_url',
    ];

    /**
     * Get the property that owns the image.
     */
    public function property(): BelongsTo
    {
        return $this->belongsTo(Property::class);
    }

    /**
     * Get the full URL to the image.
     */
    public function getUrlAttribute(): string
    {
        return asset('storage/' . $this->path);
    }

    /**
     * Get the URL to the thumbnail version of the image.
     */
    public function getThumbnailUrlAttribute(): string
    {
        // Assuming you'll create thumbnails using intervention/image or similar
        $pathInfo = pathinfo($this->path);
        
        // Build the thumbnail path, handling cases where extension might not exist
        $extension = $pathInfo['extension'] ?? '';
        $thumbnailPath = $pathInfo['dirname'] . '/thumbs/' . $pathInfo['filename'] . '_thumb' . 
                        ($extension ? '.' . $extension : '');
        
        return file_exists(storage_path('app/public/' . $thumbnailPath)) 
            ? asset('storage/' . $thumbnailPath)
            : $this->url; // Fallback to original if thumbnail doesn't exist
    }

    /**
     * Scope a query to only include featured images.
     */
    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    /**
     * Scope a query to order images by their order attribute.
     */
    public function scopeOrdered($query)
    {
        return $query->orderBy('order')->orderBy('created_at');
    }

    /**
     * Get the image dimensions (width x height).
     *
     * @return array{width: int, height: int}|null
     */
    public function getDimensions(): ?array
    {
        $path = storage_path('app/public/' . $this->path);
        
        if (!file_exists($path)) {
            return null;
        }

        try {
            list($width, $height) = getimagesize($path);
            return [
                'width' => $width,
                'height' => $height,
            ];
        } catch (\Exception $e) {
            return null;
        }
    }
}
