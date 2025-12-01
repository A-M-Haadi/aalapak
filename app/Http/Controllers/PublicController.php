<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PublicController extends Controller
{

    public function index(Request $request)
    {
        $categories = Category::all();
        
        $searchQuery = $request->input('search');
        $filterCategory = $request->input('category');
        $sortPrice = $request->input('sort');

        $productsQuery = Product::whereHas('store', function($storeQuery) {
            $storeQuery->whereHas('user', function($userQuery) {
                $userQuery->where('store_status', 'approved');
            });
        });

        if ($searchQuery) {
            $productsQuery->where('name', 'like', '%' . $searchQuery . '%');
        }

        if ($filterCategory) {
            $productsQuery->where('category_id', $filterCategory);
        }

        if ($sortPrice) {
            $productsQuery->orderBy('price', $sortPrice);
        }

        $products = $productsQuery->get();

        $favoriteProductIds = [];
        if (Auth::check() && Auth::user()->role == 'buyer') {
            $favoriteProductIds = Auth::user()->favorites()->pluck('product_id')->toArray();
        }

        return view('welcome', compact(
            'products', 
            'searchQuery', 
            'categories', 
            'filterCategory', 
            'sortPrice',
            'favoriteProductIds'
        ));
    }

    public function show(Product $product)
    {
        if ($product->store->user->store_status !== 'approved') {
            abort(404);
        }

        $product->load(['reviews' => function($query) {
            $query->orderBy('created_at', 'desc')->with('user');
        }]);

        $averageRating = $product->reviews->avg('rating');
        $reviewCount = $product->reviews->count();

        return view('product-detail', compact('product', 'averageRating', 'reviewCount'));
    }
}