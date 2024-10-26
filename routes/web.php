<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\SubcategoryController;
use App\Http\Controllers\ProductController;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\Route;



// Group for Categories
Route::group(['prefix' => 'categories'], function () {
    Route::get('/', [CategoryController::class, 'index'])->name('categories.index'); 
    Route::get('/create', [CategoryController::class, 'create'])->name('categories.create'); 
    Route::post('/', [CategoryController::class, 'store'])->name('categories.store'); 
    Route::get('/{category}', [CategoryController::class, 'show'])->name('categories.show'); 
    Route::get('/{category}/edit', [CategoryController::class, 'edit'])->name('categories.edit'); 
    Route::put('/{category}', [CategoryController::class, 'update'])->name('categories.update'); 
    Route::delete('/{category}', [CategoryController::class, 'destroy'])->name('categories.destroy'); 
});

// Group for Subcategories
Route::group(['prefix' => 'subcategories'], function () {
    Route::get('/', [SubcategoryController::class, 'index'])->name('subcategories.index');
    Route::get('/create', [SubcategoryController::class, 'create'])->name('subcategories.create');
    Route::post('/', [SubcategoryController::class, 'store'])->name('subcategories.store');
    Route::get('/{subcategory}', [SubcategoryController::class, 'show'])->name('subcategories.show');
    Route::get('/{subcategory}/edit', [SubcategoryController::class, 'edit'])->name('subcategories.edit');
    Route::put('/{subcategory}', [SubcategoryController::class, 'update'])->name('subcategories.update');
    Route::delete('/{subcategory}', [SubcategoryController::class, 'destroy'])->name('subcategories.destroy');
});

// Group for Products
Route::group(['prefix' => 'products'], function () {
    Route::get('/', [ProductController::class, 'index'])->name('products.index');
    Route::get('/create', [ProductController::class, 'create'])->name('products.create');
    Route::post('/', [ProductController::class, 'store'])->name('products.store');
    Route::get('/{product}', [ProductController::class, 'show'])->name('products.show');
    Route::get('/{product}/edit', [ProductController::class, 'edit'])->name('products.edit');
    Route::put('/{product}', [ProductController::class, 'update'])->name('products.update');
    Route::delete('/{product}', [ProductController::class, 'destroy'])->name('products.destroy');
});

// Additional routes
Route::get('/', [ProductController::class, 'showAllProducts']);
Route::get('/show-all-product', [ProductController::class, 'showAllProducts'])->name('view.products');
Route::get('/product-details', [ProductController::class, 'productDetails'])->name('product_details');
Route::delete('/confirm-delete/{id}', [SubcategoryController::class, 'confirmDelete'])->name('confirm.delete');
Route::delete('/confirm-category-delete/{id}', [CategoryController::class, 'confirmDelete'])->name('confirm_category.delete');
Route::post('/filter-products', [ProductController::class, 'filterProducts'])->name('filter.products');
Route::delete('/product/{id}/image/{image}', [ProductController::class, 'removeImage'])->name('product.image.remove');
Route::get('/getSubcategories/{categoryId}', [ProductController::class, 'getSubcategories'])->name('get.subcategories');