<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\CartPage;
use App\Livewire\DashboardPage;

Route::get('/', function () { return view('welcome'); })->name('home');

Route::get('/shop', function () {
    return view('shop');
})->name('shop');

Route::get('/cart', CartPage::class)->middleware(['auth'])->name('cart');

Route::get('dashboard', DashboardPage::class)
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

Route::get('/products/{product}', [App\Http\Controllers\ProductController::class, 'showJson'])->name('products.showJson');

require __DIR__.'/auth.php';
