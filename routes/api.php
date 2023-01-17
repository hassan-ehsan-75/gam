<?php

use App\Http\Controllers\CandinateController;
use App\Http\Controllers\ImportController;
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
Route::post('candidates-vote', [CandinateController::class,'candidatesVotes'])->name('candidates.votes2');
Route::post('stocks/answer', [ImportController::class,'answer'])->name('stock.answer');
Route::post('stocks/enter', [ImportController::class,'enterStock'])->name('stock.enter');
Route::get('stocks/get-stat', [ImportController::class,'getState'])->name('stock.getState');
Route::get('stocks/get-stocks', [ImportController::class,'getStock'])->name('stock.get');
Route::get('link',function (){
   \Illuminate\Support\Facades\Artisan::call('storage:link');
});
