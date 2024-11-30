<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\MaterialController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\ProjectPaymentController;
use App\Http\Controllers\WorkerController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\ProjectWorkerController;

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
	Route::get('categories/getsubcategories/{category}', [CategoryController::class, 'getSubcategories'])->name('categories.getsubcategories');

	Route::resource('categories', CategoryController::class);

	
	Route::get('invoices/createInProject/{project}', [InvoiceController::class, 'createInProject'])->name('invoices.createInProject');
	Route::get('invoices/editInProject/{invoice}/{project}', [InvoiceController::class, 'editInProject'])->name('invoices.editInProject');
	Route::get('invoices/showInProject/{invoice}/{project}', [InvoiceController::class, 'showInProject'])->name('invoices.showInProject');

	Route::get('invoices/addmaterial', [InvoiceController::class, 'addMaterial'])->name('invoices.addMaterial');
	Route::put('invoices/payinvoice/{invoice}', [InvoiceController::class, 'payInvoice'])->name('invoices.payInvoice');
	Route::get('invoices/getbuttons/{invoice}', [InvoiceController::class, 'getButtons'])->name('invoices.getButtons');
	Route::get('invoices/pdf/{invoice}', [InvoiceController::class, 'pdf'])->name('invoices.pdf');

	Route::get('invoices/showPayments/{invoice}', [InvoiceController::class, 'showPayments'])->name('invoices.showPayments');

	Route::resource('project_payments', ProjectPaymentController::class);
	Route::get('project_payments/getaddeditmodal/{project}/{id?}', [ProjectPaymentController::class, 'getAddEditModal'])->name('project_payments.getAddEditModal');


	Route::resource('invoices', InvoiceController::class);

	Route::get('materials/getdataautocomplete', [MaterialController::class, 'getDataAutocomplete'])->name('materials.getDataAutocomplete');
	Route::get('materials/getaddeditmodal/{id?}', [MaterialController::class, 'getAddEditModal'])->name('materials.getAddEditModal');
	Route::get('materials/getbyid/{material}', [MaterialController::class, 'getById'])->name('materials.getById');

	Route::resource('materials', MaterialController::class);

	Route::get('workers/getaddeditmodal/{id?}', [WorkerController::class, 'getAddEditModal'])->name('workers.getAddEditModal');
	Route::get('workers/getworker/{worker}', [WorkerController::class, 'getWorker'])->name('workers.getWorker');
	
	Route::resource('workers', WorkerController::class);

	Route::get('projects/getclientinfo/{client}', [ProjectController::class, 'getClientInfo'])->name('projects.getClientInfo');
	Route::get('projects/getaddeditmodal/{id?}', [ProjectController::class, 'getAddEditModal'])->name('projects.getAddEditModal');
	
	Route::get('project_workers/getaddeditmodal/{project}/{id?}', [ProjectWorkerController::class, 'getAddEditModal'])->name('project_workers.getAddEditModal');
	Route::post('project_workers', [ProjectWorkerController::class, 'store'])->name('project_workers.store');
	Route::put('project_workers/{project_worker}', [ProjectWorkerController::class, 'update'])->name('project_workers.update');
	Route::delete('project_workers/{project_worker}', [ProjectWorkerController::class, 'destroy'])->name('project_workers.destroy');

	Route::post('projects/uploadImage/{project}', [ProjectController::class, 'uploadImage'])->name('projects.uploadImage');
	Route::delete('projects/deleteImage/{project_picture}', [ProjectController::class, 'deleteImage'])->name('projects.deleteImage');
	Route::resource('projects', ProjectController::class);

});



