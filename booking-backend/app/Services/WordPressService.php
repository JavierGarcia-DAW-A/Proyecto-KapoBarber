<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class WordPressService
{
    protected $apiUrl;

    public function __construct()
    {
        // Use the absolute URL via config or fallback to our local test URL
        $this->apiUrl = config('services.wordpress.url', 'http://localhost/Proyecto-KapoBarber/wp-json/wp/v2');
    }

    /**
     * Fetch the barbers (postraits) from the WordPress REST API.
     * 
     * @return array
     */
    public function getBarbers()
    {
        try {
            // WordPress default query per_page is 10, increasing it just in case
            $response = Http::timeout(5)->get("{$this->apiUrl}/postrait", [
                'per_page' => 100,
            ]);

            if ($response->successful()) {
                return collect($response->json())->map(function ($postrait) {
                    return [
                        'id' => $postrait['id'],
                        'name' => html_entity_decode($postrait['title']['rendered'] ?? 'Barber ' . $postrait['id']),
                        'slug' => $postrait['slug'] ?? 'barber-' . $postrait['id'],
                    ];
                })->toArray();
            }

            Log::warning("WordPress API returned " . $response->status() . " when fetching barbers.");
            return [];
        } catch (\Exception $e) {
            Log::error("Error fetching barbers from WordPress API: " . $e->getMessage());
            return []; // Fail gracefully, maybe returning an empty array
        }
    }
}
