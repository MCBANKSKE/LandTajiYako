<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Str;

class Property extends Model
{
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'title',
        'slug',
        'description',
        'type',
        'county_id',
        'sub_county_id',
        'ward',
        'address',
        'nearest_landmark',
        'size',
        'size_unit',
        'bedrooms',
        'bathrooms',
        'floors',
        'price',
        'discounted_price',
        'price_negotiable',
        'is_installment_available',
        'deposit',
        'status',
        'is_featured',
        'is_verified',
        'featured_image',
        'youtube_video_link',
        'google_map_link',
        'amenities',
        'features',
        'additional_info',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'price' => 'decimal:2',
        'discounted_price' => 'decimal:2',
        'deposit' => 'decimal:2',
        'size' => 'decimal:2',
        'is_featured' => 'boolean',
        'is_verified' => 'boolean',
        'price_negotiable' => 'boolean',
        'is_installment_available' => 'boolean',
        'amenities' => 'array',
        'features' => 'array',
        
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($property) {
            if (empty($property->slug)) {
                $property->slug = Str::slug($property->title);
            }
        });

    }

    /**
     * Get the route key for the model.
     */
    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    /**
     * Get the county that owns the property.
     */
    public function county(): BelongsTo
    {
        return $this->belongsTo(County::class, 'county_id', 'id');
    }

    /**
     * Get the images for the property.
     */
    public function propertyImages(): HasMany
    {
        return $this->hasMany(PropertyImage::class);
    }

    /**
     * Get the sub-county that owns the property.
     */
    public function subCounty(): BelongsTo
    {
        return $this->belongsTo(SubCounty::class, 'sub_county_id', 'id');
    }

   

    /**
     * Get the images for the property.
     */
    public function images(): HasMany
    {
        return $this->hasMany(PropertyImage::class);
    }

    /**
     * Get the featured image URL.
     */
    public function getFeaturedImageUrlAttribute(): ?string
    {
        return $this->featured_image ? asset('storage/' . $this->featured_image) : null;
    }

    /**
     * Scope a query to only include available properties.
     */
    public function scopeAvailable($query)
    {
        return $query->where('status', 'available');
    }

    /**
     * Scope a query to only include featured properties.
     */
    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    /**
     * Scope a query to only include verified properties.
     */
    public function scopeVerified($query)
    {
        return $query->where('is_verified', true);
    }

    /**
     * Get the display price of the property.
     */
    public function getDisplayPriceAttribute(): string
    {
        $price = $this->discounted_price ?? $this->price;
        return 'KSh ' . number_format($price, 2);
    }

    /**
     * Check if the property is on discount.
     */
    public function getIsOnDiscountAttribute(): bool
    {
        return !is_null($this->discounted_price) && $this->discounted_price < $this->price;
    }

    /**
     * Get the discount percentage.
     */
    public function getDiscountPercentageAttribute(): ?int
    {
        if (!$this->is_on_discount) {
            return null;
        }

        return (int) round((($this->price - $this->discounted_price) / $this->price) * 100);
    }
}
