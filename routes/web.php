<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\MaterialController;
use App\Http\Controllers\InvoiceController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::middleware('auth')->group(function () {
	Route::get('/home', [HomeController::class, 'index'])->name('home');

	Route::get('clients/getaddeditmodal/{id?}', [ClientController::class, 'getAddEditModal'])->name('clients.getAddEditModal');
	Route::resource('clients', ClientController::class);

	Route::get('suppliers/getaddeditmodal/{id?}', [SupplierController::class, 'getAddEditModal'])->name('suppliers.getAddEditModal');
	Route::resource('suppliers', SupplierController::class);

	Route::get('categories/getaddeditmodal/{id?}', [CategoryController::class, 'getAddEditModal'])->name('categories.getAddEditModal');
	Route::post('categories/savesubcategory/{category_id}', [CategoryController::class, 'saveSubcategory'])->name('categories.saveSubcategory');
	Route::get('categories/selectsubcategory/{category}', [CategoryController::class, 'selectSubcategory'])->name('categories.selectSubcategory');

	Route::post('categories/saveItem/{subcategory_id}', [CategoryController::class, 'saveItem'])->name('categories.saveItem');

	
	Route::resource('categories', CategoryController::class);

	Route::resource('materials', MaterialController::class);
});



