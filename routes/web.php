<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProductStockController;
use App\Http\Controllers\PurchaseController;
use App\Http\Livewire\Product;
use App\Models\Order;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('index');
});
Route::get('dashboard', [DashboardController::class,'index'])->name('dashboard');


Route::prefix('product')->group(function () {
    Route::get("datagrid",[ProductController::class,'datagrid']);
    Route::get("data",[ProductController::class,'products']);
});
Route::resource('product',ProductController::class);

Route::prefix('order')->group(function () {
    Route::get("datagrid",[OrderController::class,'datagrid']);
    Route::get("print",[OrderController::class,'print'])->name('order-print');
});
Route::resource("order",OrderController::class);

Route::prefix('purchase')->group(function () {
    Route::get("datagrid",[PurchaseController::class,'datagrid']);
    Route::post("saveOrder",[PurchaseController::class,'saveOrder']);
    Route::post("completeOrder",[PurchaseController::class,'completeOrder']);
    Route::post("cancelOrder",[PurchaseController::class,'cancelOrder']);
});
Route::resource("purchase",PurchaseController::class);

Route::prefix('productStock')->group(function () {
    Route::get("datagrid",[ProductStockController::class,'datagrid']);
    
});
Route::resource("productStock",ProductStockController::class);



// Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
//     return view('dashboard');
// })->name('dashboard');


