<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class BackendApiService
{
    protected string $baseUrl;

    public function __construct()
    {
        $defaultUrl = 'https://gurucrackers.onrender.com';
        $configured = config('services.backend.url') ?: env('BACKEND_API_URL', $defaultUrl);
        $this->baseUrl = rtrim($configured ?: $defaultUrl, '/');
    }

    public function getBaseUrl(): string
    {
        return $this->baseUrl;
    }

    public function getInit(): array
    {
        try {
            $response = Http::withoutVerifying()->timeout(15)->get("{$this->baseUrl}/api/v1/init");
            if ($response->successful()) {
                return $response->json();
            }
        } catch (\Throwable $e) {
            Log::warning("BackendApiService getInit failed: " . $e->getMessage());
        }

        return [
            'success' => false,
            'shop' => [
                'name' => 'Guru Crackers',
                'tagline' => 'Sivakasi Direct Crackers',
                'phone' => '9789874381',
                'min_order_amount' => 0,
            ],
            'banners' => [],
        ];
    }

    public function getCatalog(): array
    {
        try {
            $response = Http::withoutVerifying()->timeout(20)->get("{$this->baseUrl}/api/v1/catalog");
            if ($response->successful()) {
                return $response->json();
            }
        } catch (\Throwable $e) {
            Log::warning("BackendApiService getCatalog failed: " . $e->getMessage());
        }

        return ['success' => false, 'categories' => []];
    }

    public function submitOrder(array $data): array
    {
        try {
            $response = Http::withoutVerifying()->timeout(25)->post("{$this->baseUrl}/api/v1/orders", $data);
            return $response->json();
        } catch (\Throwable $e) {
            Log::error("BackendApiService submitOrder failed: " . $e->getMessage());
            return [
                'success' => false,
                'message' => 'Network error connecting to store server. Please check your internet connection.',
            ];
        }
    }

    public function trackOrder(array $params): array
    {
        try {
            $response = Http::withoutVerifying()->timeout(15)->post("{$this->baseUrl}/api/v1/orders/track", $params);
            return $response->json();
        } catch (\Throwable $e) {
            Log::error("BackendApiService trackOrder failed: " . $e->getMessage());
            return [
                'success' => false,
                'message' => 'Network error connecting to store server.',
                'orders' => [],
            ];
        }
    }

    public function getOrder(string $orderNumber): array
    {
        try {
            $response = Http::withoutVerifying()->timeout(15)->get("{$this->baseUrl}/api/v1/orders/{$orderNumber}");
            return $response->json();
        } catch (\Throwable $e) {
            Log::error("BackendApiService getOrder failed: " . $e->getMessage());
            return ['success' => false, 'message' => 'Failed to load order.'];
        }
    }

    public function sendOtp(array $data): array
    {
        try {
            $response = Http::withoutVerifying()->timeout(20)->post("{$this->baseUrl}/api/v1/orders/send-otp", $data);
            return $response->json();
        } catch (\Throwable $e) {
            Log::error("BackendApiService sendOtp failed: " . $e->getMessage());
            return [
                'success' => false,
                'message' => 'Network error connecting to store server. Please check your internet connection.',
            ];
        }
    }

    public function verifyOtp(array $data): array
    {
        try {
            $response = Http::withoutVerifying()->timeout(20)->post("{$this->baseUrl}/api/v1/orders/verify-otp", $data);
            return $response->json();
        } catch (\Throwable $e) {
            Log::error("BackendApiService verifyOtp failed: " . $e->getMessage());
            return [
                'success' => false,
                'message' => 'Network error connecting to store server. Please check your internet connection.',
            ];
        }
    }
    public function lookupPincode(string $pincode): array
    {
        try {
            $response = Http::withoutVerifying()->timeout(10)->get("{$this->baseUrl}/api/v1/orders/pincode/{$pincode}");
            return $response->json() ?? ['success' => false, 'message' => 'Invalid server response'];
        } catch (\Throwable $e) {
            Log::error("BackendApiService lookupPincode failed: " . $e->getMessage());
            return [
                'success' => false,
                'message' => 'Network error connecting to store server.',
            ];
        }
    }
}
