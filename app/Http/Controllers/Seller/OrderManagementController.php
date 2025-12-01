<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderManagementController extends Controller
{

    public function index()
    {
        $storeId = Auth::user()->store->id;

        $orders = Order::whereHas('items', function($query) use ($storeId) {
            $query->where('store_id', $storeId);
        })
        ->with(['items' => function($query) use ($storeId) {
            $query->where('store_id', $storeId)->with('product');
        }])
        ->orderBy('created_at', 'desc')
        ->get();

        return view('seller.orders.index', compact('orders'));
    }

    public function show(Order $order)
    {
        $storeId = Auth::user()->store->id;

        $order = Order::where('id', $order->id)
            ->whereHas('items', function($query) use ($storeId) {
                $query->where('store_id', $storeId);
            })
            ->with(['items' => function($query) use ($storeId) {
                $query->where('store_id', $storeId)->with('product');
            }, 'user'])
            ->firstOrFail();

        return view('seller.orders.show', compact('order'));
    }

    public function update(Request $request, Order $order)
    {
        $storeId = Auth::user()->store->id;

        $hasPermission = $order->items()->where('store_id', $storeId)->exists();
        if (!$hasPermission) {
            abort(403, 'Unauthorized action.');
        }

        $request->validate([
            'status' => 'required|string|in:Menunggu Pembayaran,Diproses,Selesai,Dibatalkan',
        ]);

        $order->status = $request->status;
        $order->save();

        return redirect()->route('seller.orders.show', $order->id)
                         ->with('success', 'Status pesanan berhasil diperbarui.');
    }
}