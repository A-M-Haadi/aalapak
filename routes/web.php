<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\CategoryController; 
use App\Http\Controllers\Admin\SellerVerificationController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\ProductManagementController;
use App\Http\Controllers\Seller\StoreController;
use App\Http\Controllers\Seller\ProductController;
use App\Http\Controllers\Seller\OrderManagementController;
use App\Http\Controllers\PublicController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\Buyer\OrderController;
use App\Http\Controllers\Buyer\ReviewController;
use App\Http\Controllers\Buyer\FavoriteController;
use App\Http\Controllers\Buyer\AddressController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

Route::get('/', [PublicController::class, 'index'])->name('home');
Route::get('/product/{product}', [PublicController::class, 'show'])->name('product.show');

// --- RUTE DASHBOARD (Penjaga Pintu) ---
Route::get('/dashboard', function (Request $request) {
    $role = Auth::user()->role;

    if ($role == 'admin') {
        return redirect()->route('admin.dashboard');
    } 
    elseif ($role == 'seller') {
        return redirect()->route('seller.dashboard'); 
    } 
    else {
        // Logika Dashboard Buyer
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

        $products = $productsQuery->inRandomOrder()->get();

        $favoriteProductIds = [];
        if (Auth::check() && Auth::user()->role == 'buyer') {
            $favoriteProductIds = Auth::user()->favorites()->pluck('product_id')->toArray();
        }
        
        return view('dashboard', compact(
            'products', 
            'searchQuery', 
            'categories', 
            'filterCategory', 
            'sortPrice',
            'favoriteProductIds'
        )); 
    }
})->middleware(['auth'])->name('dashboard');

// --- RUTE PROFILE (Breeze Default) ---
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Import rute autentikasi (login, register, dll)
require __DIR__.'/auth.php';


// --- RUTE ADMIN ---
Route::middleware(['auth', 'admin'])->group(function () {
    
    Route::prefix('admin')->name('admin.')->group(function () {
        Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
        // CRUD Kategori
        Route::resource('categories', CategoryController::class);

        // Verifikasi Seller
        Route::get('/sellers', [SellerVerificationController::class, 'index'])->name('sellers.index');
        Route::patch('/sellers/{user}', [SellerVerificationController::class, 'update'])->name('sellers.update');
        
        // Manajemen User
        Route::resource('users', UserController::class)->only([
            'index', 'edit', 'update', 'destroy'
        ]);
        
        // Manajemen Produk (Hapus)
        Route::get('/products', [ProductManagementController::class, 'index'])->name('products.index');
        Route::delete('/products/{product}', [ProductManagementController::class, 'destroy'])->name('products.destroy');
    });

});


// --- RUTE SELLER ---
// 1. Rute Pending (Bisa diakses seller yang belum diapprove)
Route::middleware(['auth'])->group(function () {
    Route::get('/seller/pending', function () {
        return view('seller.pending'); 
    })->name('seller.pending');
});

// 2. Dashboard & Fitur Seller (Hanya untuk seller approved)
Route::middleware(['auth', 'seller'])->group(function () {

    Route::prefix('seller')->name('seller.')->group(function () {
        // Dashboard
        Route::get('/dashboard', [StoreController::class, 'dashboard'])->name('dashboard');

        // Manajemen Toko
        Route::get('/store/create', [StoreController::class, 'create'])->name('store.create');
        Route::post('/store', [StoreController::class, 'store'])->name('store.store');
        Route::get('/store/edit', [StoreController::class, 'edit'])->name('store.edit');
        Route::patch('/store', [StoreController::class, 'update'])->name('store.update');

        // CRUD Produk
        Route::resource('products', ProductController::class);

        // Manajemen Pesanan
        Route::get('/orders', [OrderManagementController::class, 'index'])->name('orders.index');
        Route::get('/orders/{order}', [OrderManagementController::class, 'show'])->name('orders.show');
        Route::patch('/orders/{order}', [OrderManagementController::class, 'update'])->name('orders.update');
    });

});


// --- RUTE BUYER ---
Route::middleware(['auth', 'buyer'])->group(function () {

    // Keranjang Belanja
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('/cart/add', [CartController::class, 'store'])->name('cart.store');
    Route::delete('/cart/remove/{cartItem}', [CartController::class, 'destroy'])->name('cart.destroy');
    Route::patch('/cart/update/{cartItem}', [CartController::class, 'update'])->name('cart.update');
    
    // Checkout
    Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
    Route::post('/checkout', [CheckoutController::class, 'store'])->name('checkout.store');
    
    // Riwayat Pesanan
    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{order}', [OrderController::class, 'show'])->name('orders.show');
    
    // Review
    Route::get('/orders/{order}/product/{product}/review', [ReviewController::class, 'create'])->name('reviews.create');
    Route::post('/reviews', [ReviewController::class, 'store'])->name('reviews.store');
    
    // Favorit / Wishlist
    Route::get('/favorites', [FavoriteController::class, 'index'])->name('favorite.index');
    Route::post('/favorite/toggle/{product}', [FavoriteController::class, 'toggle'])->name('favorite.toggle');
    
    // Alamat Pengiriman
    Route::resource('addresses', AddressController::class);
});