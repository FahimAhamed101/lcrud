<?php
use App\Http\Controllers\ProductControllerApi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
Route::get('/products', [ProductControllerApi::class, 'indexapi'])->name('product');
Route::get('/products/{id}', [ProductControllerApi::class, 'show'])->name('product');
Route::post('/products/add', [ProductControllerApi::class, 'storeapi'])->name('product');