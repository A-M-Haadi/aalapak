<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\CartItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function index()
    {
        $cartItems = CartItem::where('user_id', Auth::id())
                             ->with('product')
                             ->get();

        $subtotal = 0;
        foreach ($cartItems as $item) {
            $subtotal += $item->product->price * $item->quantity;
        }

        return view('cart.index', compact('cartItems', 'subtotal'));
    }

public function store(Request $request)
{
    $request->validate([
        'product_id' => 'required|exists:products,id',
        'quantity'   => 'required|integer|min:1'
    ]);

    $product = Product::find($request->product_id);
    $userId = Auth::id();

    // Cek item yang SUDAH ada di keranjang user
    $existingItem = CartItem::where('user_id', $userId)
                            ->where('product_id', $request->product_id)
                            ->first();

    // Hitung total bayangan (jumlah di keranjang + jumlah yang mau ditambah)
    $currentCartQty = $existingItem ? $existingItem->quantity : 0;
    $newTotalQty = $currentCartQty + $request->quantity;

    // VALIDASI KETAT: Jika total melebihi stok
    if ($newTotalQty > $product->stock) {
        return redirect()->back()->with('error', 'Stok tidak cukup! Anda sudah punya ' . $currentCartQty . ' di keranjang, sisa stok hanya ' . $product->stock . '.');
    }

    // Jika lolos, baru simpan/update
    if ($existingItem) {
        $existingItem->quantity += $request->quantity;
        $existingItem->save();
    } else {
        CartItem::create([
            'user_id' => $userId,
            'product_id' => $request->product_id,
            'quantity' => $request->quantity,
        ]);
    }

    return redirect()->back()->with('success', 'Produk berhasil ditambahkan ke keranjang!');
}

    public function update(Request $request, CartItem $cartItem)
    {
        if ($cartItem->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        $request->validate([
            'quantity' => 'required|integer|min:1|max:' . $cartItem->product->stock,
        ], [
            'quantity.max' => 'Jumlah melebihi stok yang tersedia (' . $cartItem->product->stock . ' item).'
        ]);

        $cartItem->quantity = $request->quantity;
        $cartItem->save();

        return redirect()->route('cart.index')->with('success', 'Jumlah produk berhasil diperbarui.');
    }

    public function destroy(CartItem $cartItem)
    {
        if ($cartItem->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        $cartItem->delete();

        return redirect()->route('cart.index')->with('success', 'Produk berhasil dihapus dari keranjang.');
    }
}