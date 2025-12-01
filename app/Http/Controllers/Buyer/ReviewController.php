<?php

namespace App\Http\Controllers\Buyer;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{

    public function create(Order $order, Product $product)
    {
        if ($order->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        if ($order->status !== 'Selesai') {
            return redirect()->route('orders.show', $order->id)->with('error', 'Anda hanya bisa memberi review untuk pesanan yang sudah Selesai.');
        }

        $itemExists = $order->items()->where('product_id', $product->id)->exists();
        if (!$itemExists) {
            abort(404, 'Produk tidak ditemukan di pesanan ini.');
        }

        $existingReview = Review::where('user_id', Auth::id())
                                ->where('order_id', $order->id)
                                ->where('product_id', $product->id)
                                ->exists();
        if ($existingReview) {
             return redirect()->route('orders.show', $order->id)->with('error', 'Anda sudah memberi review untuk produk ini.');
        }

        return view('buyer.reviews.create', compact('order', 'product'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'order_id' => 'required|exists:orders,id',
            'product_id' => 'required|exists:products,id',
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:1000',
        ]);

        $validatedData['user_id'] = Auth::id();

        $order = Order::find($validatedData['order_id']);
        if ($order->user_id !== Auth::id() || $order->status !== 'Selesai') {
             abort(403, 'Aksi tidak diizinkan.');
        }

        $existingReview = Review::where('user_id', $validatedData['user_id'])
                                ->where('order_id', $validatedData['order_id'])
                                ->where('product_id', $validatedData['product_id'])
                                ->exists();
        if ($existingReview) {
             return redirect()->route('orders.show', $order->id)->with('error', 'Anda sudah memberi review untuk produk ini.');
        }

        Review::create($validatedData);

        return redirect()->route('orders.show', $validatedData['order_id'])
                         ->with('success', 'Terima kasih atas review Anda!');
    }
}