<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class PropertyImage extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'property_id',
        'title',
        'slug',
        'path',
        'filename',
        'original_name',
        'mime_type',
        'file_size',
        'alt_text',
        'caption',
        'description',
        'order',
        'type',
        'is_featured',
        'is_primary',
        'is_approved',
        'width',
        'height',
        'disk',
        'directory',
    ];

    protected $casts = [
        'order' => 'integer',
        'file_size' => 'integer',
        'width' => 'integer',
        'height' => 'integer',
        'is_featured' => 'boolean',
        'is_primary' => 'boolean',
        'is_approved' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    protected $appends = [
        'url',
        'thumbnail_url',
        'medium_url',
        'large_url',
        'file_size_formatted',
        'dimensions',
        'is_image',
    ];

    protected static function boot(): void
    {
        parent::boot();

        static::creating(function (self $image) {
            if (empty($image->slug) && !empty($image->title)) {
                $image->slug = \Illuminate\Support\Str::slug($image->title);
            }
            
            // Generate filename if not provided
            if (empty($image->filename)) {
                $image->filename = pathinfo($image->path, PATHINFO_BASENAME);
            }
        });

        static::created(function (self $image) {
            // Generate thumbnails after creation
            $image->generateThumbnails();
        });

        static::updating(function (self $image) {
            if ($image->isDirty('is_primary') && $image->is_primary) {
                // Ensure only one primary image per property
                static::where('property_id', $image->property_id)
                    ->where('id', '!=', $image->id)
                    ->update(['is_primary' => false]);
            }
            
            if ($image->isDirty('is_featured') && $image->is_featured) {
                // Ensure only one featured image per property
                static::where('property_id', $image->property_id)
                    ->where('id', '!=', $image->id)
                    ->update(['is_featured' => false]);
            }
        });

        static::deleted(function (self $image) {
            // Delete physical files
            if ($image->forceDeleting) {
                $image->deleteFiles();
            }
        });
    }

    public function property(): BelongsTo
    {
        return $this->belongsTo(Property::class);
    }

    public function thumbnails(): HasMany
    {
        return $this->hasMany(PropertyImageThumbnail::class);
    }

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    public function scopePrimary($query)
    {
        return $query->where('is_primary', true);
    }

    public function scopeImages($query)
    {
        return $query->where('type', 'image');
    }

    public function scopeFloorPlans($query)
    {
        return $query->where('type', 'floor_plan');
    }

    public function scopeApproved($query)
    {
        return $query->where('is_approved', true);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('order')->orderBy('created_at');
    }

    protected function url(): Attribute
    {
        return Attribute::make(
            get: fn () => Storage::disk($this->disk)->url($this->path)
        );
    }

    protected function thumbnailUrl(): Attribute
    {
        return Attribute::make(
            get: function () {
                $thumbnail = $this->thumbnails()->where('size_name', 'thumbnail')->first();
                return $thumbnail ? Storage::disk($this->disk)->url($thumbnail->path) : $this->url;
            }
        );
    }

    protected function mediumUrl(): Attribute
    {
        return Attribute::make(
            get: function () {
                $medium = $this->thumbnails()->where('size_name', 'medium')->first();
                return $medium ? Storage::disk($this->disk)->url($medium->path) : $this->url;
            }
        );
    }

    protected function largeUrl(): Attribute
    {
        return Attribute::make(
            get: function () {
                $large = $this->thumbnails()->where('size_name', 'large')->first();
                return $large ? Storage::disk($this->disk)->url($large->path) : $this->url;
            }
        );
    }

    protected function fileSizeFormatted(): Attribute
    {
        return Attribute::make(
            get: function () {
                $units = ['B', 'KB', 'MB', 'GB'];
                $bytes = $this->file_size;
                $i = 0;
                
                while ($bytes >= 1024 && $i < count($units) - 1) {
                    $bytes /= 1024;
                    $i++;
                }
                
                return round($bytes, 2) . ' ' . $units[$i];
            }
        );
    }

    protected function dimensions(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->width && $this->height ? "{$this->width}×{$this->height}" : null
        );
    }

    protected function isImage(): Attribute
    {
        return Attribute::make(
            get: fn () => str_starts_with($this->mime_type, 'image/')
        );
    }

    public function generateThumbnails(): void
    {
        if (!$this->is_image) {
            return;
        }

        $sizes = [
            'thumbnail' => ['width' => 300, 'height' => 200],
            'medium' => ['width' => 800, 'height' => 600],
            'large' => ['width' => 1200, 'height' => 800],
        ];

        foreach ($sizes as $sizeName => $dimensions) {
            $this->generateThumbnail($sizeName, $dimensions['width'], $dimensions['height']);
        }
    }

    private function generateThumbnail(string $sizeName, int $width, int $height): void
    {
        $fullPath = Storage::disk($this->disk)->path($this->path);
        
        if (!file_exists($fullPath)) {
            return;
        }

        $manager = new ImageManager(new Driver());
        $image = $manager->read($fullPath);
        
        // Resize maintaining aspect ratio
        $image->scaleDown($width, $height);
        
        // Create directory if it doesn't exist
        $thumbDir = dirname($this->path) . '/thumbs/' . $sizeName;
        Storage::disk($this->disk)->makeDirectory($thumbDir);
        
        // Generate unique filename
        $extension = pathinfo($this->filename, PATHINFO_EXTENSION);
        $thumbFilename = pathinfo($this->filename, PATHINFO_FILENAME) . "_{$sizeName}.{$extension}";
        $thumbPath = $thumbDir . '/' . $thumbFilename;
        
        // Save thumbnail
        $image->save(Storage::disk($this->disk)->path($thumbPath), quality: 85);
        
        // Store thumbnail record
        $this->thumbnails()->create([
            'size_name' => $sizeName,
            'path' => $thumbPath,
            'width' => $image->width(),
            'height' => $image->height(),
            'quality' => 85,
        ]);
    }

    public function deleteFiles(): void
    {
        // Delete main file
        Storage::disk($this->disk)->delete($this->path);
        
        // Delete all thumbnails
        foreach ($this->thumbnails as $thumbnail) {
            Storage::disk($this->disk)->delete($thumbnail->path);
            $thumbnail->delete();
        }
    }

    public function setAsFeatured(): void
    {
        $this->update(['is_featured' => true]);
    }

    public function setAsPrimary(): void
    {
        $this->update(['is_primary' => true]);
    }

    public function getAspectRatio(): ?float
    {
        if (!$this->width || !$this->height) {
            return null;
        }
        
        return $this->width / $this->height;
    }

    public function isPortrait(): bool
    {
        return $this->getAspectRatio() < 1;
    }

    public function isLandscape(): bool
    {
        return $this->getAspectRatio() > 1;
    }

    public function isSquare(): bool
    {
        $ratio = $this->getAspectRatio();
        return $ratio && abs($ratio - 1) < 0.01;
    }
}