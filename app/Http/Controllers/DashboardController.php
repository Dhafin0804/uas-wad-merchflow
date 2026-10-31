<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Models\Order;

class DashboardController extends Controller
{
    public function index()
    {
        // Menghitung jumlah data
        $totalProducts = Product::count();
        $totalCategories = Category::count();
        $totalOrders = Order::count();

        // Menghitung pesanan berdasarkan status
        $ordersByStatus = Order::selectRaw('status, COUNT(*) as total')
            ->groupBy('status')
            ->get();

        // Mengambil 5 pesanan terbaru
        $latestOrders = Order::latest()
            ->take(5)
            ->get();

        return view('dashboard.index', compact(
            'totalProducts',
            'totalCategories',
            'totalOrders',
            'ordersByStatus',
            'latestOrders'
        ));
    }
}
