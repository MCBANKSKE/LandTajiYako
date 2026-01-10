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
        $featuredProperties = Property::with(['county', 'subCounty', 'images' => function ($query) {
            $query->where('is_primary', true)->orWhere('is_featured', true);
        }])
            ->featured()
            ->available()
            ->verified()
            ->published()
            ->latest()
            ->take(8)
            ->get();

        // Get counties for the search form with property count
        $counties = County::withCount(['properties' => function ($query) {
            $query->available()->published();
        }])
            ->orderBy('county_name')
            ->get();

        // Get premium properties
        $premiumProperties = Property::with(['county', 'images'])
            ->premium()
            ->available()
            ->published()
            ->latest()
            ->take(3)
            ->get();

        // Get latest properties
        $latestProperties = Property::with(['county', 'images'])
            ->available()
            ->published()
            ->latest()
            ->take(6)
            ->get();

        // Get property statistics
        $stats = [
            'total_properties' => Property::available()->published()->count(),
            'featured_properties' => Property::featured()->available()->published()->count(),
            'premium_properties' => Property::premium()->available()->published()->count(),
            'verified_properties' => Property::verified()->available()->published()->count(),
            'properties_sold' => Property::where('status', 'sold')->count(),
            'properties_rented' => Property::where('status', 'rented')->count(),
        ];

        // Get featured testimonials
        $testimonials = Testimonial::featured()
            ->ordered()
            ->with('user')
            ->take(6)
            ->get();

        return view('welcome', compact(
            'featuredProperties',
            'counties',
            'premiumProperties',
            'latestProperties',
            'stats',
            'testimonials'
        ));
    }

    /**
     * Search properties from homepage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function search(Request $request)
    {
        $searchParams = $request->only([
            'location', 'property_type', 'price_range', 
            'bedrooms', 'bathrooms', 'size_range'
        ]);

        // Add price range logic
        if ($request->filled('price_range')) {
            $priceRange = $request->input('price_range');
            if ($priceRange === 'custom') {
                if ($request->filled('min_price')) {
                    $searchParams['min_price'] = $request->input('min_price');
                }
                if ($request->filled('max_price')) {
                    $searchParams['max_price'] = $request->input('max_price');
                }
            }
        }

        return redirect()->route('properties.index', $searchParams);
    }

    /**
     * Display about us page.
     *
     * @return \Illuminate\View\View
     */
    public function about()
    {
        $teamStats = [
            'years_experience' => 15,
            'properties_sold' => 2847,
            'happy_clients' => 1562,
            'locations' => 47,
        ];

        return view('pages.about', compact('teamStats'));
    }

    /**
     * Display contact us page.
     *
     * @return \Illuminate\View\View
     */
    public function contact()
    {
        return view('pages.contact');
    }

    /**
     * Display FAQs page.
     *
     * @return \Illuminate\View\View
     */
    public function faqs()
    {
        $faqs = [
            [
                'question' => 'How do I schedule a property viewing?',
                'answer' => 'You can schedule a viewing by contacting us directly through our contact form, calling our office, or using the "Schedule Viewing" button on any property listing.',
            ],
            [
                'question' => 'What documents do I need to purchase a property?',
                'answer' => 'Typically you will need: National ID, KRA PIN, Passport photos, and proof of income. For specific properties, additional documents may be required.',
            ],
            [
                'question' => 'Do you offer property financing options?',
                'answer' => 'Yes, we partner with various financial institutions to provide mortgage and financing options. Many of our properties are available for installment purchase.',
            ],
            [
                'question' => 'How can I verify a property is legally owned?',
                'answer' => 'All our properties undergo thorough due diligence. We verify title deeds, land rates clearance, and ownership documents before listing any property.',
            ],
            [
                'question' => 'What is your commission structure?',
                'answer' => 'Our commission varies based on property type and value. We offer competitive rates and transparent pricing. Contact us for specific commission details.',
            ],
            [
                'question' => 'Can I list my property with you?',
                'answer' => 'Absolutely! We welcome property owners to list with us. Contact our listing department for valuation and marketing options.',
            ],
        ];

        return view('pages.faqs', compact('faqs'));
    }

    /**
     * Display privacy policy.
     *
     * @return \Illuminate\View\View
     */
    public function privacyPolicy()
    {
        return view('pages.privacy-policy');
    }

    /**
     * Display terms and conditions.
     *
     * @return \Illuminate\View\View
     */
    public function terms()
    {
        return view('pages.terms');
    }
}