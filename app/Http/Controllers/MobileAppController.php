<?php

namespace App\Http\Controllers;

use App\Services\BackendApiService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class MobileAppController extends Controller
{
    /**
     * Mobile Home & Product Catalog screen.
     */
    public function index(BackendApiService $api): View
    {
        $initData = $api->getInit();
        $catalogData = $api->getCatalog();

        $shop = $initData['shop'] ?? [];
        $banners = $initData['banners'] ?? [];
        $categories = $catalogData['categories'] ?? [];

        $backendUrl = $api->getBaseUrl();

        return view('mobile.catalog', compact('shop', 'banners', 'categories', 'backendUrl'));
    }

    /**
     * Submit order from mobile app to central server API.
     */
    public function submitOrder(Request $request, BackendApiService $api): JsonResponse
    {
        $products = $request->input('products', []);
        if (is_array($products)) {
            foreach ($products as $p) {
                $q = is_array($p) ? ($p['qty'] ?? 0) : $p;
                if ((int)$q > 20) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Maximum quantity allowed is 20 units per item.',
                    ], 422);
                }
            }
        }

        $result = $api->submitOrder($request->all());

        $status = ($result['success'] ?? false) ? 200 : 422;
        return response()->json($result, $status);
    }

    /**
     * Order Success & UPI Payment Screen.
     */
    public function success(string $orderNumber, BackendApiService $api): View
    {
        $result = $api->getOrder($orderNumber);
        $order = $result['order'] ?? null;
        $shop = $result['shop'] ?? [];
        $invoiceUrl = $result['invoice_url'] ?? null;
        $downloadPdfUrl = $result['download_pdf_url'] ?? null;

        $backendUrl = $api->getBaseUrl();

        return view('mobile.success', compact('order', 'shop', 'orderNumber', 'invoiceUrl', 'downloadPdfUrl', 'backendUrl'));
    }

    /**
     * Order Tracking screen & AJAX lookup.
     */
    public function track(Request $request, BackendApiService $api)
    {
        if ($request->wantsJson() || $request->isMethod('post')) {
            $data = $api->trackOrder($request->all());
            return response()->json($data);
        }

        return redirect('/#track');
    }
}
