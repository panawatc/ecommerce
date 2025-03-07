<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Order;

class DashboardController extends Controller
{
    public function index()
    {
        $productCount = Product::count();
        $orderCount = Order::count();
        $totalRevenue = Order::where('status', '!=', 'cancelled')->sum('total');
        
        $recentOrders = Order::orderBy('created_at', 'desc')
            ->take(5)
            ->get();
            
        $lowStockProducts = Product::where('stock', '<', 10)
            ->orderBy('stock', 'asc')
            ->take(5)
            ->get();
            
        return view('admin.dashboard.index', compact(
            'productCount',
            'orderCount',
            'totalRevenue',
            'recentOrders',
            'lowStockProducts'
        ));
    }
}