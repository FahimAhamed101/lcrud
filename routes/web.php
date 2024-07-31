<?php
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\IndexController;
Route::get('product/details/{id}', [IndexController::class, 'productDetails']);

// ------------------------------ Admin Product Manage Page----------------------------------
Route::get('/', [ProductController::class, 'index'])->name('product');
Route::get('product/add', [ProductController::class, 'add'])->name('product.add');
Route::post('product/store', [ProductController::class, 'Store'])->name('product.store');
Route::get('product/edit/{id}', [ProductController::class, 'Edit'])->name('product.edit');
Route::post('product/update', [ProductController::class, 'Update'])->name('product.update');
Route::get('product/delete/{id}', [ProductController::class, 'Delete'])->name('product.delete');
    //  Main Image update route --------------------------------------------------------------------
Route::post('product/image/update', [ProductController::class, 'MainImageUpdate'])->name('product.mainImage.update');
Route::post('product/multiImage/update', [ProductController::class, 'MultiImageUpdate'])->name('product.multiImage.update');
Route::get('product/delete/multiImage/{id}', [ProductController::class, 'MultiImageDelete'])->name('product.multiImage.delete');