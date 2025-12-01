<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\CartItem;
use App\Models\Address;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class CheckoutController extends Controller
{

    public function index()
    {
        $user = Auth::user();
        $cartItems = $user->cartItems()->with('product')->get();
        $addresses = $user->addresses;

        if ($cartItems->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Keranjang Anda kosong.');
        }

        $subtotal = 0;
        foreach ($cartItems as $item) {
            $subtotal += $item->product->price * $item->quantity;
        }

        return view('checkout.index', compact('cartItems', 'addresses', 'subtotal'));
    }

    public function store(Request $request)
    {
        $user = Auth::user();
        $cartItems = $user->cartItems()->with('product')->get();

        $request->validate([
            'address_id' => [
                'required',

                Rule::exists('addresses', 'id')->where('user_id', $user->id)
            ]
        ], [
            'address_id.required' => 'Anda harus memilih alamat pengiriman.'
        ]);

        if ($cartItems->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Keranjang Anda kosong.');
        }

        try {
            DB::beginTransaction();

            $totalPrice = 0;
            foreach ($cartItems as $item) {
                $product = $item->product;
                if ($product->stock < $item->quantity) {
                    DB::rollBack();
                    return redirect()->route('cart.index')
                                     ->with('error', 'Stok untuk produk "' . $product->name . '" tidak mencukupi.');
                }
                $totalPrice += $product->price * $item->quantity;
            }

            $order = Order::create([
                'user_id' => $user->id,
                'total_price' => $totalPrice,
                'status' => 'Menunggu Pembayaran',
                'address_id' => $request->address_id,
            ]);

            foreach ($cartItems as $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item->product_id,
                    'store_id' => $item->product->store_id,
                    'quantity' => $item->quantity,
                    'price' => $item->product->price,
                ]);
                $item->product->decrement('stock', $item->quantity);
            }
            $user->cartItems()->delete();

            DB::commit();

            return redirect()->route('orders.index')
                             ->with('success', 'Pesanan Anda berhasil dibuat!');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('cart.index')
                             ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}