<?php

namespace App\Http\Controllers;

use App\Models\Property;
use App\Models\County;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PropertyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Property::query()->with(['county', 'subCounty', 'images']);

        // Search by location (county, sub-county, or address)
        if ($request->filled('location')) {
            $location = $request->input('location');
            $query->where(function($q) use ($location) {
                $q->where('address', 'like', "%{$location}%")
                  ->orWhere('ward', 'like', "%{$location}%")
                  ->orWhereHas('county', function($q) use ($location) {
                      $q->where('name', 'like', "%{$location}%");
                  })
                  ->orWhereHas('subCounty', function($q) use ($location) {
                      $q->where('name', 'like', "%{$location}%");
                  });
            });
        }

        // Filter by property type
        if ($request->filled('property_type')) {
            $query->where('type', $request->input('property_type'));
        }

        // Filter by price range
        if ($request->filled('price_range')) {
            $priceRange = $request->input('price_range');
            if (str_contains($priceRange, '+')) {
                $minPrice = (float) str_replace('+', '', $priceRange);
                $query->where('price', '>=', $minPrice);
            } else {
                list($minPrice, $maxPrice) = explode('-', $priceRange);
                $query->whereBetween('price', [(float)$minPrice, (float)$maxPrice]);
            }
        }

        // Filter by bedrooms
        if ($request->filled('bedrooms')) {
            $bedrooms = $request->input('bedrooms');
            if ($bedrooms === '5+') {
                $query->where('bedrooms', '>=', 5);
            } else {
                $query->where('bedrooms', (int)$bedrooms);
            }
        }

        // Filter by bathrooms
        if ($request->filled('bathrooms')) {
            $bathrooms = $request->input('bathrooms');
            if ($bathrooms === '4+') {
                $query->where('bathrooms', '>=', 4);
            } else {
                $query->where('bathrooms', (int)$bathrooms);
            }
        }

        // Get the results
        $properties = $query->where('status', 'available')
                           ->orderBy('is_featured', 'desc')
                           ->orderBy('created_at', 'desc')
                           ->paginate(12);

        // Get filter options for the sidebar
        $propertyTypes = Property::select('type')
            ->distinct()
            ->pluck('type');

        $counties = County::orderBy('county_name')->get();
        
        // Get featured properties
        $featuredProperties = Property::where('is_featured', true)
            ->where('status', 'available')
            ->with(['county', 'subCounty', 'images'])
            ->take(4)
            ->get();

        return view('properties.index', compact('properties', 'propertyTypes', 'counties', 'featuredProperties'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Property $property)
    {
        $property->load(['county', 'subCounty', 'images']);
        $relatedProperties = Property::where('county_id', $property->county_id)
            ->where('id', '!=', $property->id)
            ->where('status', 'available')
            ->inRandomOrder()
            ->take(4)
            ->get();

        return view('properties.show', compact('property', 'relatedProperties'));
    }

    // Other methods (create, store, edit, update, destroy) can be kept as is or implemented as needed
}
