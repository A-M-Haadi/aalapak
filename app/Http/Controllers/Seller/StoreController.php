<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class StoreController extends Controller
{

    public function dashboard()
    {
        $store = Auth::user()->store;

        return view('seller.dashboard', compact('store'));
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
        
    }

    public function update(Request $request)
    {

    }

}