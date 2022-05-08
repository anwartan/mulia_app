<?php

use App\Http\Controllers\OrderController;
use App\Http\Livewire\Product;
use App\Models\Order;
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
Route::get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');
Route::prefix('order')->group(function () {
    Route::get("datagrid",[OrderController::class,'datagrid']);
    Route::get("print",[OrderController::class,'print'])->name('order-print');
});

Route::resource("order",OrderController::class);

Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');


