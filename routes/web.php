<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\CategoryController; 
use App\Http\Controllers\Admin\SellerVerificationController;
use App\Http\Controllers\Seller\StoreController;
use App\Http\Controllers\Seller\ProductController;
use App\Http\Controllers\PublicController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;

Route::get('/', [PublicController::class, 'index'])->name('home');
Route::get('/product/{product}', [PublicController::class, 'show'])->name('product.show');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

Route::middleware(['auth', 'admin'])->group(function () {
    
    Route::prefix('admin')->name('admin.')->group(function () {

        Route::resource('categories', CategoryController::class);

        Route::get('/sellers', [SellerVerificationController::class, 'index'])->name('sellers.index');
        Route::patch('/sellers/{user}', [SellerVerificationController::class, 'update'])->name('sellers.update');
        Route::resource('users', UserController::class)->only([
                'index', 'edit', 'update', 'destroy'
            ]);
        Route::get('/products', [ProductManagementController::class, 'index'])->name('products.index');
        Route::delete('/products/{product}', [ProductManagementController::class, 'destroy'])->name('products.destroy');
    });

});

Route::middleware(['auth'])->group(function () {
    Route::get('/seller/pending', function () {
        return view('seller.pending'); 
    })->name('seller.pending');
});

Route::middleware(['auth', 'seller'])->group(function () {

    Route::prefix('seller')->name('seller.')->group(function () {
        Route::get('/dashboard', [StoreController::class, 'dashboard'])->name('dashboard');

        Route::get('/store/create', [StoreController::class, 'create'])->name('store.create');
        Route::post('/store', [StoreController::class, 'store'])->name('store.store');
        Route::get('/store/edit', [StoreController::class, 'edit'])->name('store.edit');
        Route::patch('/store', [StoreController::class, 'update'])->name('store.update');
        Route::resource('products', ProductController::class);
    });

});

Route::middleware(['auth', 'buyer'])->group(function () {

    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('/cart/add', [CartController::class, 'store'])->name('cart.store');
    Route::delete('/cart/remove/{cartItem}', [CartController::class, 'destroy'])->name('cart.destroy');
    Route::patch('/cart/update/{cartItem}', [CartController::class, 'update'])->name('cart.update');
    Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
    Route::post('/checkout', [CheckoutController::class, 'store'])->name('checkout.store');
});