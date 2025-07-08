<?php

namespace App\Http\Controllers;

use App\Models\Listing;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

class ListingImportController extends Controller
{
    public function import(Request $request)
    {
        if (Cache::has('last_realtor_import')) {
            return back()->with('error', 'You can import listings only once a day');
        }

        $response = Http::withHeaders([
            'X-RapidAPI-Key' => env('REALTOR_API_KEY'),
            'X-RapidAPI-Host' => 'realtor-search.p.rapidapi.com',
        ])->get('https://realtor-search.p.rapidapi.com/properties/search-buy', [
            'location' => 'city:NY',
            'sortBy' => 'newest',
            'limit' => 5,
        ]);

        $results = $response->json('data.results') ?? [];

        foreach ($results as $item) {
            $address = $item['location']['address'] ?? [];
            $desc = $item['description'] ?? [];

            $listing = Listing::create([
                'beds' => $desc['beds'] ?? 0,
                'baths' => $desc['baths'] ?? 0,
                'area' => $desc['sqft'] ?? 0,
                'price' => $item['list_price'] ?? 0,
                'city' => $address['city'] ?? 'Unknown',
                'code' => $address['postal_code'] ?? '',
                'street' => $address['line'] ?? '',
                'street_nr' => $address['street_number'] ?? '',
                'by_user_id' => User::first()?->id ?? 1,
            ]);

            if (!empty($item['primary_photo']['href'])) {
                $listing->images()->create([
                    'filename' => $item['primary_photo']['href']
                ]);
            }

            if (!empty($item['photos']) && is_array($item['photos'])) {
                foreach (array_slice($item['photos'], 0, 4) as $photo) {
                    if (!empty($photo['href'])) {
                        $listing->images()->create([
                            'filename' => $photo['href']
                        ]);
                    }
                }
            }
        }

        Cache::put('last_realtor_import', now(), now()->addMinutes(1440));

        return back()->with('success', 'Listings and images imported successfully!');
    }
}
