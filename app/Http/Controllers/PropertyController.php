<?php

namespace App\Http\Controllers;

use App\Models\Property;
use App\Models\County;
use App\Models\SubCounty;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;

class PropertyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Property::query()
            ->with(['county', 'subCounty', 'images' => function ($query) {
                $query->where('is_primary', true)->orWhere('is_featured', true);
            }])
            ->available()
            ->published();

        // Search by location (county, sub-county, address, or ward)
        if ($request->filled('location')) {
            $location = $request->input('location');
            $query->where(function ($q) use ($location) {
                $q->where('address', 'like', "%{$location}%")
                  ->orWhere('ward', 'like', "%{$location}%")
                  ->orWhere('nearest_landmark', 'like', "%{$location}%")
                  ->orWhereHas('county', function ($q) use ($location) {
                      $q->where('county_name', 'like', "%{$location}%");
                  })
                  ->orWhereHas('subCounty', function ($q) use ($location) {
                      $q->where('constituency_name', 'like', "%{$location}%");
                  })
                  ->orWhereJsonContains('tags', $location);
            });
        }

        // Filter by property type
        if ($request->filled('property_type')) {
            $query->where('type', $request->input('property_type'));
        }

        // Filter by listing type (sale/rent)
        if ($request->filled('listing_type')) {
            $query->where('listing_type', $request->input('listing_type'));
        }

        // Filter by price range
        if ($request->filled('price_range')) {
            $priceRange = $request->input('price_range');
            if ($priceRange === 'custom') {
                if ($request->filled('min_price')) {
                    $query->where('price', '>=', (float) $request->input('min_price'));
                }
                if ($request->filled('max_price')) {
                    $query->where('price', '<=', (float) $request->input('max_price'));
                }
            } elseif (str_contains($priceRange, '+')) {
                $minPrice = (float) str_replace(['KES ', '+', ','], '', $priceRange);
                $query->where('price', '>=', $minPrice);
            } else {
                $prices = explode('-', $priceRange);
                if (count($prices) === 2) {
                    $minPrice = (float) str_replace(['KES ', ','], '', $prices[0]);
                    $maxPrice = (float) str_replace(['KES ', ','], '', $prices[1]);
                    $query->whereBetween('price', [$minPrice, $maxPrice]);
                }
            }
        }

        // Filter by bedrooms
        if ($request->filled('bedrooms')) {
            $bedrooms = $request->input('bedrooms');
            if ($bedrooms === '5+') {
                $query->where('bedrooms', '>=', 5);
            } elseif ($bedrooms === 'any') {
                // No filter
            } else {
                $query->where('bedrooms', (int) $bedrooms);
            }
        }

        // Filter by bathrooms
        if ($request->filled('bathrooms')) {
            $bathrooms = $request->input('bathrooms');
            if ($bathrooms === '4+') {
                $query->where('bathrooms', '>=', 4);
            } elseif ($bathrooms === 'any') {
                // No filter
            } else {
                $query->where('bathrooms', (int) $bathrooms);
            }
        }

        // Filter by size range
        if ($request->filled('size_range')) {
            $sizeRange = $request->input('size_range');
            if ($sizeRange === 'custom') {
                if ($request->filled('min_size')) {
                    $query->where('size', '>=', (float) $request->input('min_size'));
                }
                if ($request->filled('max_size')) {
                    $query->where('size', '<=', (float) $request->input('max_size'));
                }
            } elseif (str_contains($sizeRange, '+')) {
                $minSize = (float) str_replace(['+', ','], '', $sizeRange);
                $query->where('size', '>=', $minSize);
            } else {
                $sizes = explode('-', $sizeRange);
                if (count($sizes) === 2) {
                    $minSize = (float) str_replace(',', '', $sizes[0]);
                    $maxSize = (float) str_replace(',', '', $sizes[1]);
                    $query->whereBetween('size', [$minSize, $maxSize]);
                }
            }
        }

        // Filter by amenities
        if ($request->filled('amenities')) {
            $amenities = (array) $request->input('amenities');
            foreach ($amenities as $amenity) {
                $query->whereJsonContains('amenities', $amenity);
            }
        }

        // Filter by features
        if ($request->filled('features')) {
            $features = (array) $request->input('features');
            foreach ($features as $feature) {
                $query->whereJsonContains('features', $feature);
            }
        }

        // Filter by county
        if ($request->filled('county_id')) {
            $query->where('county_id', $request->input('county_id'));
        }

        // Filter by sub-county
        if ($request->filled('sub_county_id')) {
            $query->where('sub_county_id', $request->input('sub_county_id'));
        }

        // Filter by property status
        if ($request->filled('status')) {
            $query->where('status', $request->input('status'));
        }

        // Filter by verification status
        if ($request->filled('is_verified')) {
            $query->where('is_verified', true);
        }

        // Filter by featured status
        if ($request->filled('is_featured')) {
            $query->where('is_featured', true);
        }

        // Filter by premium status
        if ($request->filled('is_premium')) {
            $query->where('is_premium', true);
        }

        // Sort options
        $sort = $request->input('sort', 'latest');
        switch ($sort) {
            case 'price_asc':
                $query->orderBy('price', 'asc');
                break;
            case 'price_desc':
                $query->orderBy('price', 'desc');
                break;
            case 'size_asc':
                $query->orderBy('size', 'asc');
                break;
            case 'size_desc':
                $query->orderBy('size', 'desc');
                break;
            case 'oldest':
                $query->orderBy('created_at', 'asc');
                break;
            case 'most_viewed':
                $query->orderBy('view_count', 'desc');
                break;
            case 'featured_first':
                $query->orderBy('is_featured', 'desc')
                    ->orderBy('created_at', 'desc');
                break;
            default: // 'latest'
                $query->latest();
                break;
        }

        // Get the results
        $perPage = $request->input('per_page', 12);
        $properties = $query->paginate($perPage)
            ->appends($request->query());

        // Get filter options for the sidebar
        $propertyTypes = Property::select('type')
            ->distinct()
            ->pluck('type')
            ->mapWithKeys(function ($type) {
                return [$type => ucfirst($type)];
            });

        $counties = County::withCount(['properties' => function ($query) {
                $query->available()->published();
            }])
            ->orderBy('county_name')
            ->get();

        $subCounties = SubCounty::withCount(['properties' => function ($query) {
                $query->available()->published();
            }])
            ->when($request->filled('county_id'), function ($query) use ($request) {
                $query->where('county_id', $request->input('county_id'));
            })
            ->orderBy('constituency_name')
            ->get();

        // Get featured properties
        $featuredProperties = Property::featured()
            ->available()
            ->published()
            ->with(['county', 'subCounty', 'images'])
            ->take(6)
            ->get();

        // Get premium properties
        $premiumProperties = Property::premium()
            ->available()
            ->published()
            ->with(['county', 'subCounty', 'images'])
            ->take(4)
            ->get();

        // Get property statistics
        $stats = [
            'total' => Property::available()->published()->count(),
            'featured' => Property::featured()->available()->published()->count(),
            'premium' => Property::premium()->available()->published()->count(),
            'verified' => Property::verified()->available()->published()->count(),
            'for_sale' => Property::forSale()->available()->published()->count(),
            'for_rent' => Property::forRent()->available()->published()->count(),
        ];

        // Get popular tags
        $popularTags = Cache::remember('popular_property_tags', 3600, function () {
            return Property::select('tags')
                ->whereNotNull('tags')
                ->get()
                ->pluck('tags')
                ->flatten()
                ->countBy()
                ->sortDesc()
                ->take(10)
                ->keys()
                ->toArray();
        });

        // Get amenities list
        $amenitiesList = Cache::remember('property_amenities_list', 3600, function () {
            return Property::select('amenities')
                ->whereNotNull('amenities')
                ->get()
                ->pluck('amenities')
                ->flatten()
                ->unique()
                ->sort()
                ->values()
                ->toArray();
        });

        // Get features list
        $featuresList = Cache::remember('property_features_list', 3600, function () {
            return Property::select('features')
                ->whereNotNull('features')
                ->get()
                ->pluck('features')
                ->flatten()
                ->unique()
                ->sort()
                ->values()
                ->toArray();
        });

        return view('properties.index', compact(
            'properties',
            'propertyTypes',
            'counties',
            'subCounties',
            'featuredProperties',
            'premiumProperties',
            'stats',
            'popularTags',
            'amenitiesList',
            'featuresList'
        ));
    }

    /**
     * Display the specified resource.
     */
    public function show(Property $property)
    {
        // Increment view count
        $property->incrementViewCount();

        // Load relationships
        $property->load([
            'county',
            'subCounty',
            'images' => function ($query) {
                $query->orderBy('order')->orderBy('is_primary', 'desc');
            }
        ]);

        // Get related properties
        $relatedProperties = Property::where('county_id', $property->county_id)
            ->where('id', '!=', $property->id)
            ->where('status', 'available')
            ->where('type', $property->type)
            ->with(['county', 'images'])
            ->inRandomOrder()
            ->take(6)
            ->get();

        // Get similar price range properties
        $similarPriceProperties = Property::whereBetween('price', [
                $property->price * 0.7,
                $property->price * 1.3
            ])
            ->where('id', '!=', $property->id)
            ->where('status', 'available')
            ->with(['county', 'images'])
            ->inRandomOrder()
            ->take(4)
            ->get();

        // Get nearby properties (if coordinates available)
        $nearbyProperties = null;
        if ($property->getLatitude() && $property->getLongitude()) {
            $nearbyProperties = Property::available()
                ->where('id', '!=', $property->id)
                ->with(['county', 'images'])
                ->take(4)
                ->get();
        }

        // Get property statistics
        $propertyStats = [
            'total_views' => $property->view_count,
            'total_contacts' => $property->contact_count,
            'days_listed' => $property->created_at->diffInDays(),
            'age_of_property' => $property->age_of_property,
        ];

        // Prepare meta data for SEO
        $meta = [
            'title' => $property->meta_title ?? $property->title . ' - ' . config('app.name'),
            'description' => $property->meta_description ?? Str::limit(strip_tags($property->description), 160),
            'keywords' => $property->meta_keywords ?? implode(', ', $property->tags ?? []),
            'image' => $property->featured_image_url,
            'url' => route('properties.show', $property),
        ];

        return view('properties.show', compact(
            'property',
            'relatedProperties',
            'similarPriceProperties',
            'nearbyProperties',
            'propertyStats',
            'meta'
        ));
    }

    /**
     * Download property brochure.
     */
    public function downloadBrochure(Property $property)
    {
        // Logic to generate and download PDF brochure
        // You'll need to implement PDF generation here
        // This is a placeholder
        return response()->download(storage_path('app/public/properties/brochures/' . $property->id . '.pdf'));
    }

    /**
     * Save property to favorites.
     */
    public function favorite(Property $property)
    {
        auth()->user()->favorites()->syncWithoutDetaching([$property->id]);
        return back()->with('success', 'Property added to favorites!');
    }

    /**
     * Remove property from favorites.
     */
    public function unfavorite(Property $property)
    {
        auth()->user()->favorites()->detach($property->id);
        return back()->with('success', 'Property removed from favorites!');
    }

    /**
     * Schedule property viewing.
     */
    public function scheduleViewing(Request $request, Property $property)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'phone' => 'required|string',
            'preferred_date' => 'required|date|after:today',
            'message' => 'nullable|string|max:1000',
        ]);

        // Increment contact count
        $property->incrementContactCount();

        // Store viewing request (you'll need to create a ViewingRequest model)
        // ViewingRequest::create([...]);

        // Send notification email
        // Mail::to(config('mail.from.address'))->send(new ViewingRequestMail($property, $request->all()));

        return back()->with('success', 'Viewing request submitted successfully! We will contact you shortly.');
    }

    /**
     * Share property.
     */
    public function share(Property $property, $platform)
    {
        $shareUrl = $this->getShareUrl($property, $platform);
        return redirect()->away($shareUrl);
    }

    /**
     * Get share URL for different platforms.
     */
    private function getShareUrl(Property $property, $platform)
    {
        $url = route('properties.show', $property);
        $title = urlencode($property->title);
        $description = urlencode(Str::limit(strip_tags($property->description), 100));

        switch ($platform) {
            case 'facebook':
                return "https://www.facebook.com/sharer/sharer.php?u={$url}&quote={$title}";
            case 'twitter':
                return "https://twitter.com/intent/tweet?url={$url}&text={$title}";
            case 'linkedin':
                return "https://www.linkedin.com/sharing/share-offsite/?url={$url}";
            case 'whatsapp':
                return "https://wa.me/?text={$title}%20{$url}";
            case 'telegram':
                return "https://t.me/share/url?url={$url}&text={$title}";
            case 'email':
                return "mailto:?subject={$title}&body={$description}%20{$url}";
            default:
                return $url;
        }
    }

    /**
     * Get property recommendations based on user preferences.
     */
    public function recommendations()
    {
        $user = auth()->user();
        $recommendations = [];

        if ($user) {
            // Get user's favorite properties types
            $favoriteTypes = $user->favorites()
                ->select('type')
                ->groupBy('type')
                ->orderByRaw('COUNT(*) DESC')
                ->pluck('type');

            if ($favoriteTypes->isNotEmpty()) {
                $recommendations = Property::available()
                    ->published()
                    ->whereIn('type', $favoriteTypes)
                    ->with(['county', 'images'])
                    ->inRandomOrder()
                    ->take(8)
                    ->get();
            }
        }

        // If no user or no favorites, show featured properties
        if (empty($recommendations)) {
            $recommendations = Property::featured()
                ->available()
                ->published()
                ->with(['county', 'images'])
                ->take(8)
                ->get();
        }

        return view('properties.recommendations', compact('recommendations'));
    }
}