<?php

namespace App\Http\Controllers;

use App\Models\Property;
use App\Models\County;
use App\Models\Testimonial;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Display the home page with featured properties.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $featuredProperties = Property::with(['images'])
            ->where('is_featured', true)
            ->where('status', 'available')
            ->latest()
            ->take(5)
            ->get();

        // Get counties for the search form
        $counties = County::orderBy('county_name')->get();
        
        // Get featured testimonials
        $testimonials = Testimonial::featured()
            ->ordered()
            ->get();

        return view('welcome', compact('featuredProperties', 'counties', 'testimonials'));
    }
}
