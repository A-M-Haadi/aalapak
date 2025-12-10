<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product; // Pastikan model Product di-import
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

        // --- TAMBAHAN BARU: CEK STOK SEBELUM TAMPILKAN HALAMAN ---
        // Ini mencegah user masuk ke checkout jika stok tidak valid
        foreach ($cartItems as $item) {
            // Ambil stok terbaru dari database (fresh)
            $product = Product::find($item->product_id);

            // Jika jumlah di keranjang lebih besar dari stok gudang
            if ($item->quantity > $product->stock) {
                return redirect()->route('cart.index')->with('error', 'Mohon maaf, stok produk "' . $product->name . '" tidak mencukupi (Sisa: ' . $product->stock . '). Silakan kurangi jumlah pesanan Anda di keranjang.');
            }
        }
        // --- AKHIR TAMBAHAN ---

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
            
            // Cek stok sekali lagi saat tombol bayar ditekan (untuk keamanan ganda)
            foreach ($cartItems as $item) {
                // Lock row product agar tidak dibeli orang lain bersamaan (Opsional tapi bagus)
                $product = Product::where('id', $item->product_id)->lockForUpdate()->first(); 
                
                if ($product->stock < $item->quantity) {
                    DB::rollBack();
                    return redirect()->route('cart.index')
                                     ->with('error', 'Gagal memproses pesanan. Stok "' . $product->name . '" baru saja habis atau tidak mencukupi.');
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
                
                // Kurangi stok
                $item->product->decrement('stock', $item->quantity);
            }
            
            // Kosongkan keranjang
            $user->cartItems()->delete();

            DB::commit();

            return redirect()->route('orders.index')
                             ->with('success', 'Pesanan Anda berhasil dibuat!');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('cart.index')
                             ->with('error', 'Terjadi kesalahan sistem: ' . $e->getMessage());
        }
    }
}