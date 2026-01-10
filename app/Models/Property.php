<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Support\Str;
use Carbon\Carbon;

class Property extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'title',
        'slug',
        'description',
        'type',
        'county_id',
        'sub_county_id',
        'ward',
        'address',
        'coordinates',
        'nearest_landmark',
        'size',
        'size_unit',
        'bedrooms',
        'bathrooms',
        'floors',
        'parking_spaces',
        'year_built',
        'price',
        'discounted_price',
        'price_negotiable',
        'is_installment_available',
        'deposit',
        'monthly_payment',
        'installment_months',
        'status',
        'listing_type',
        'is_featured',
        'is_verified',
        'is_premium',
        'featured_until',
        'verified_at',
        'featured_image',
        'image_gallery',
        'virtual_tour_link',
        'youtube_video_link',
        'google_map_link',
        'amenities',
        'features',
        'additional_info',
        'tags',
        'meta_title',
        'meta_description',
        'meta_keywords',
        'view_count',
        'contact_count',
        'last_viewed_at',
        'published_at',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'discounted_price' => 'decimal:2',
        'deposit' => 'decimal:2',
        'monthly_payment' => 'decimal:2',
        'size' => 'decimal:2',
        'coordinates' => 'point',
        'is_featured' => 'boolean',
        'is_verified' => 'boolean',
        'is_premium' => 'boolean',
        'price_negotiable' => 'boolean',
        'is_installment_available' => 'boolean',
        'amenities' => 'array',
        'features' => 'array',
        'tags' => 'array',
        'image_gallery' => 'array',
        'meta_keywords' => 'array',
        'verified_at' => 'datetime',
        'featured_until' => 'datetime',
        'published_at' => 'datetime',
        'last_viewed_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    protected $appends = [
        'display_price',
        'is_on_discount',
        'discount_percentage',
        'featured_image_url',
        'formatted_size',
        'age_of_property',
        'is_featured_active',
        'is_published',
        'status_label',
    ];

    protected static function boot(): void
    {
        parent::boot();

        static::creating(function (self $property) {
            if (empty($property->slug)) {
                $property->slug = Str::slug($property->title);
            }
            
            if (empty($property->published_at) && $property->status === 'available') {
                $property->published_at = now();
            }
        });

        static::updating(function (self $property) {
            // Ensure slug uniqueness
            if ($property->isDirty('slug') && !$property->slug) {
                $property->slug = Str::slug($property->title);
            }
            
            // Update published_at if becoming available
            if ($property->isDirty('status') && $property->status === 'available' && !$property->published_at) {
                $property->published_at = now();
            }
        });
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    public function scopeAvailable($query)
    {
        return $query->where('status', 'available');
    }

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true)
            ->where(function ($q) {
                $q->whereNull('featured_until')
                  ->orWhere('featured_until', '>=', now());
            });
    }

    public function scopeVerified($query)
    {
        return $query->where('is_verified', true)
            ->whereNotNull('verified_at');
    }

    public function scopePremium($query)
    {
        return $query->where('is_premium', true);
    }

    public function scopeForSale($query)
    {
        return $query->where('listing_type', 'sale');
    }

    public function scopeForRent($query)
    {
        return $query->where('listing_type', 'rent');
    }

    public function scopePublished($query)
    {
        return $query->whereNotNull('published_at')
            ->where('published_at', '<=', now());
    }

    public function scopeSearch($query, string $search)
    {
        return $query->where(function ($q) use ($search) {
            $q->where('title', 'like', "%{$search}%")
              ->orWhere('description', 'like', "%{$search}%")
              ->orWhere('address', 'like', "%{$search}%")
              ->orWhere('nearest_landmark', 'like', "%{$search}%")
              ->orWhereJsonContains('tags', $search);
        });
    }

    public function county(): BelongsTo
    {
        return $this->belongsTo(County::class);
    }

    public function subCounty(): BelongsTo
    {
        return $this->belongsTo(SubCounty::class, 'sub_county_id');
    }

    public function images(): HasMany
    {
        return $this->hasMany(PropertyImage::class)->orderBy('order');
    }

    public function featuredImage(): HasMany
    {
        return $this->hasMany(PropertyImage::class)->where('is_featured', true);
    }

    public function primaryImage(): HasMany
    {
        return $this->hasMany(PropertyImage::class)->where('is_primary', true);
    }

    protected function displayPrice(): Attribute
    {
        return Attribute::make(
            get: fn () => 'KSh ' . number_format($this->discounted_price ?? $this->price, 2)
        );
    }

    protected function isOnDiscount(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->discounted_price && $this->discounted_price < $this->price
        );
    }

    protected function discountPercentage(): Attribute
    {
        return Attribute::make(
            get: function () {
                if (!$this->is_on_discount) {
                    return null;
                }
                
                return (int) round((($this->price - $this->discounted_price) / $this->price) * 100);
            }
        );
    }

    protected function featuredImageUrl(): Attribute
    {
        return Attribute::make(
            get: function () {
                if (!$this->featured_image) {
                    return $this->images->first()?->url ?? asset('images/default-property.jpg');
                }
                
                return Storage::disk('public')->url($this->featured_image);
            }
        );
    }

    protected function formattedSize(): Attribute
    {
        return Attribute::make(
            get: function () {
                $size = number_format($this->size, 2);
                $unitLabels = [
                    'sqft' => 'sq ft',
                    'acres' => 'acres',
                    'hectares' => 'hectares',
                    'square_meters' => 'm²',
                ];
                
                return "{$size} " . ($unitLabels[$this->size_unit] ?? $this->size_unit);
            }
        );
    }

    protected function ageOfProperty(): Attribute
    {
        return Attribute::make(
            get: function () {
                if (!$this->year_built) {
                    return null;
                }
                
                return now()->year - $this->year_built;
            }
        );
    }

    protected function isFeaturedActive(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->is_featured && (!$this->featured_until || $this->featured_until->isFuture())
        );
    }

    protected function isPublished(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->published_at && $this->published_at->isPast()
        );
    }

    protected function statusLabel(): Attribute
    {
        return Attribute::make(
            get: function () {
                $labels = [
                    'available' => ['label' => 'Available', 'color' => 'success'],
                    'sold' => ['label' => 'Sold', 'color' => 'danger'],
                    'rented' => ['label' => 'Rented', 'color' => 'warning'],
                    'under_offer' => ['label' => 'Under Offer', 'color' => 'info'],
                    'off_market' => ['label' => 'Off Market', 'color' => 'secondary'],
                ];
                
                return $labels[$this->status] ?? ['label' => ucfirst($this->status), 'color' => 'secondary'];
            }
        );
    }

    public function incrementViewCount(): void
    {
        $this->increment('view_count');
        $this->last_viewed_at = now();
        $this->saveQuietly();
    }

    public function incrementContactCount(): void
    {
        $this->increment('contact_count');
        $this->saveQuietly();
    }

    public function getLatitude(): ?float
    {
        if (!$this->coordinates) {
            return null;
        }
        
        // Assuming coordinates are stored as POINT(lat lng)
        preg_match('/POINT\(([^ ]+) ([^ ]+)\)/', $this->coordinates, $matches);
        return $matches[1] ?? null;
    }

    public function getLongitude(): ?float
    {
        if (!$this->coordinates) {
            return null;
        }
        
        preg_match('/POINT\(([^ ]+) ([^ ]+)\)/', $this->coordinates, $matches);
        return $matches[2] ?? null;
    }

    public function scopeNearby($query, float $latitude, float $longitude, int $radius = 10)
    {
        return $query->whereRaw(
            "ST_Distance_Sphere(point(?, ?), point(?, ?)) <= ? * 1000",
            [
                $this->getLatitude(),
                $this->getLongitude(),
                $latitude,
                $longitude,
                $radius
            ]
        );
    }

    public function getMonthlyPayment(): ?string
    {
        if (!$this->is_installment_available || !$this->installment_months) {
            return null;
        }
        
        $amount = $this->price - ($this->deposit ?? 0);
        $monthly = $amount / $this->installment_months;
        
        return 'KSh ' . number_format($monthly, 2);
    }

    public function markAsFeatured(int $days = 30): void
    {
        $this->update([
            'is_featured' => true,
            'featured_until' => now()->addDays($days),
        ]);
    }

    public function markAsVerified(): void
    {
        $this->update([
            'is_verified' => true,
            'verified_at' => now(),
        ]);
    }
}