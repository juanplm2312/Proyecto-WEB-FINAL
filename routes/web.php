<?php

use App\Http\Controllers\GiftController;
use App\Http\Controllers\ExchangeController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

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

Route::get('/', function(){ return redirect()->route('gifts.index'); });

Route::middleware(['auth'])->group(function(){
    Route::resource('gifts', GiftController::class);
    Route::resource('exchanges', ExchangeController::class)->only(['index','show','store','update','destroy']);
    Route::post('gifts/{gift}/wish', [GiftController::class,'toggleWish'])->name('gifts.wish');
    // etc
});

require __DIR__.'/auth.php'; // Breeze auth routes

require __DIR__.'/auth.php';
