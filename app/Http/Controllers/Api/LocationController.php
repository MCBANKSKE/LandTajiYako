<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\County;
use App\Models\SubCounty;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class LocationController extends Controller
{
    /**
     * Autocomplete locations (counties and sub-counties)
     */
    public function autocomplete(Request $request): JsonResponse
    {
        $query = $request->get('q');
        
        if (empty($query) || strlen($query) < 2) {
            return response()->json([]);
        }
        
        // Search counties
        $counties = County::where('county_name', 'LIKE', "%{$query}%")
            ->limit(5)
            ->get(['id', 'county_name as name', 'county_name as type']);
        
        // Search sub-counties
        $subcounties = SubCounty::with('county')
            ->where('sub_county_name', 'LIKE', "%{$query}%")
            ->limit(5)
            ->get(['id', 'sub_county_name as name', 'county_id'])
            ->map(function ($subcounty) {
                return [
                    'id' => $subcounty->id,
                    'name' => $subcounty->name,
                    'type' => $subcounty->county->county_name . ' - Sub County',
                    'county_id' => $subcounty->county_id
                ];
            });
        
        // Mark counties as type
        $counties = $counties->map(function ($county) {
            return [
                'id' => $county->id,
                'name' => $county->name,
                'type' => 'County',
                'county_id' => $county->id
            ];
        });
        
        $results = $counties->concat($subcounties);
        
        return response()->json($results);
    }
}
