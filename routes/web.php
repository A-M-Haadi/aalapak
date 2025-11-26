<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\CategoryController; 
use App\Http\Controllers\Admin\SellerVerificationController;

Route::get('/', function () {
    return view('welcome');
});

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