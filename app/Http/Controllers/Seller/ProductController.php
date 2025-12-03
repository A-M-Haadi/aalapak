<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Models\Category;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{

    public function index()
    {
        $storeId = Auth::user()->store->id;
        $products = Product::where('store_id', $storeId)->get();
        return view('seller.products.index', compact('products'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('seller.products.create', compact('categories'));
    }

    public function store(Request $request)
    { 
        $validatedData = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|integer|min:0',
            'stock' => 'required|integer|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $storeId = Auth::user()->store->id;

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('product_images', 'public');
            $validatedData['image'] = $path;
        }

        $validatedData['store_id'] = $storeId;

        Product::create($validatedData);

        return redirect()->route('seller.products.index')
                         ->with('success', 'Produk baru berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        //
    }

    public function edit(Product $product)
    {
        if ($product->store_id !== Auth::user()->store->id) {
            abort(403, 'Unauthorized action.');
        }

        $categories = Category::all();

        return view('seller.products.edit', compact('product', 'categories'));
    }

    public function update(Request $request, Product $product)
    {
        if ($product->store_id !== Auth::user()->store->id) {
            abort(403, 'Unauthorized action.');
        }

        $validatedData = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|integer|min:0',
            'stock' => 'required|integer|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('image')) {
            if ($product->image) {
                Storage::disk('public')->delete($product->image);
            }
            $path = $request->file('image')->store('product_images', 'public');
            $validatedData['image'] = $path;
        }

        $product->update($validatedData);

        return redirect()->route('seller.products.index')
                         ->with('success', 'Produk berhasil diperbarui.');
    }

    public function destroy(Product $product)
    {
        if ($product->store_id !== Auth::user()->store->id) {
            abort(403, 'Unauthorized action.');
        }

        if ($product->image) {
            Storage::disk('public')->delete($product->image);
        }

        $product->delete();

        return redirect()->route('seller.products.index')
                         ->with('success', 'Produk berhasil dihapus.');
    }
}
