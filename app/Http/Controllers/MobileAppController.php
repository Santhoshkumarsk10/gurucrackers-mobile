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

        return view('mobile.catalog', compact('shop', 'banners', 'categories'));
    }

    /**
     * Submit order from mobile app to central server API.
     */
    public function submitOrder(Request $request, BackendApiService $api): JsonResponse
    {
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

        return view('mobile.success', compact('order', 'shop', 'orderNumber', 'invoiceUrl', 'downloadPdfUrl'));
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

        $initData = $api->getInit();
        $shop = $initData['shop'] ?? [];

        return view('mobile.track', compact('shop'));
    }
}
