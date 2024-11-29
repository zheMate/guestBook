<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MessageController;


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
    return view('message');
});
Route::get('/getall', [MessageController::class, 'getall'])->name('getall');
Route::post('/store', [MessageController::class, 'store'])->name('store');
Route::delete('/message/delete', [MessageController::class, 'delete'])->name('delete');
