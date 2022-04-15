<?php

use App\Http\Controllers\OfferController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/list-offer', [OfferController::class, 'list'])->name('offer.list');
Route::post('/create-offer', [OfferController::class, 'store'])->name('offer.store');
Route::post('/confirm-offer', [OfferController::class, 'confirm'])->name('offer.confirm');

