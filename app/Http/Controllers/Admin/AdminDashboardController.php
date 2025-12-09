<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Product;
use App\Models\Order;
use Illuminate\Http\Request;

class AdminDashboardController extends Controller
{
    public function index()
    {
        // Hitung statistik untuk dashboard
        $totalUsers = User::count();
        $totalSellers = User::where('role', 'seller')->count();
        $totalProducts = Product::count();
        $totalOrders = Order::count();
        
        // Ambil data terbaru (opsional)
        $latestOrders = Order::with('user')->latest()->take(5)->get();
        $pendingSellers = User::where('role', 'seller')->where('store_status', 'pending')->count();

        return view('admin.dashboard', compact(
            'totalUsers', 
            'totalSellers', 
            'totalProducts', 
            'totalOrders',
            'latestOrders',
            'pendingSellers'
        ));
    }
}