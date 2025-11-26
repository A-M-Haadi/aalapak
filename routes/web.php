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
    Route::prefix('admin')->name('admin.')->group(function () {
        Route::resource('categories', CategoryController::class);
        Route::get('/sellers', [SellerVerificationController::class, 'index'])->name('sellers.index');
        Route::patch('/sellers/{user}', [SellerVerificationController::class, 'update'])->name('sellers.update');
    });
});

require __DIR__.'/auth.php';
