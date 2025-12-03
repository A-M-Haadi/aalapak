<?php

namespace App\Http\Controllers\Buyer;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FavoriteController extends Controller
{

    public function index()
    {
        $favorites = Auth::user()->favorites()->get();

        return view('buyer.favorites.index', compact('favorites'));
    }

    public function toggle(Product $product)
    {
        $user = Auth::user();

        $isFavorited = $user->favorites()->where('product_id', $product->id)->exists();

        if ($isFavorited) {
            $user->favorites()->detach($product->id);
            $message = 'Produk dihapus dari favorit.';
        } else {
            $user->favorites()->attach($product->id);
            $message = 'Produk ditambahkan ke favorit.';
        }

        return redirect()->back()->with('success', $message);
    }
}