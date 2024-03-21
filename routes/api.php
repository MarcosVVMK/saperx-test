<?php

use App\Http\Controllers\Api\V1\PhonebookController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

//Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//    return $request->user();
//});

Route::prefix('V1')->group(function () {
    Route::get('/phonebook', [PhonebookController::class, 'index'])->name('phonebook.index');
    Route::post( '/phonebook', [PhonebookController::class, 'store'])->name('phonebook.store');
    Route::put( '/phonebook/{id}', [PhonebookController::class, 'update'])->name('phonebook.update');
    Route::delete( '/phonebook/{id}', [PhonebookController::class, 'destroy'])->name('phonebook.destroy');
});
