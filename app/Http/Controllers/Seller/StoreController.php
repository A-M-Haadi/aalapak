<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use App\Models\OrderItem;
use App\Models\Product;

class StoreController extends Controller
{

    public function dashboard()
    {
        $user = Auth::user();
        $store = $user->store;

        if (!$store) {
            return redirect()->route('seller.store.create');
        }

        $totalProducts = $store->products()->count();

        $totalOrders = OrderItem::where('store_id', $store->id)->count();

        $totalRevenue = OrderItem::where('store_id', $store->id)
            ->whereHas('order', function($query) {
                $query->where('status', 'Selesai');
            })
            ->get()
            ->sum(function($item) {
                return $item->price * $item->quantity;
            });

        return view('seller.dashboard', compact('store', 'totalProducts', 'totalOrders', 'totalRevenue'));
    }

    public function create()
    {
        if (Auth::user()->store) {
            return redirect()->route('seller.store.edit');
        }

        return view('seller.store.create');
    }

    public function store(Request $request)
    {
        if (Auth::user()->store) {
            return redirect()->route('seller.store.edit');
        }

        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('store_images', 'public');
            $validatedData['image'] = $path;
        }

        Auth::user()->store()->create($validatedData);

        return redirect()->route('seller.dashboard')
                         ->with('success', 'Toko Anda berhasil dibuat!');
    }

    public function edit()
    {
        $store = Auth::user()->store;

        if (!$store) {
            return redirect()->route('seller.store.create')
                             ->with('error', 'Anda harus membuat toko terlebih dahulu.');
        }

        return view('seller.store.edit', compact('store'));
    }

    public function update(Request $request)
    {
        $store = Auth::user()->store;

        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        if ($request->hasFile('image')) {
            if ($store->image) {
                Storage::disk('public')->delete($store->image);
            }

            $path = $request->file('image')->store('store_images', 'public');
            $validatedData['image'] = $path;
        }

        $store->update($validatedData);

        return redirect()->route('seller.dashboard')
                         ->with('success', 'Informasi toko berhasil diperbarui!');
    }
}