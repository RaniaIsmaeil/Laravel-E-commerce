<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\AuthController;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});


Route::post('login', [AuthController::class,'login']);
Route::post('register', [AuthController::class,'register']);
Route::post('logout', [AuthController::class,'logout']);
Route::group(['middleware' => 'auth.jwt'], function () {

});

Route::get('/categories',[CategoryController::class, 'index']);
Route::post('/categories',[CategoryController::class, 'store']);
Route::get('categories/{id}', [CategoryController::class,'show']);
Route::put('categories/{id}', [CategoryController::class,'update']);
Route::delete('categories/{id}', [CategoryController::class,'destroy']);

Route::get('/items',[ItemController::class, 'index']);
Route::post('/items',[ItemController::class, 'store']);
Route::get('items/{id}', [ItemController::class,'show']);
Route::put('items/{id}', [ItemController::class,'update']);
Route::delete('items/{id}', [ItemController::class,'destroy']);

Route::get('/messages',[MessageController::class, 'index']);
Route::post('/messages',[MessageController::class, 'store']);
Route::get('messages/{id}', [MessageController::class,'show']);
Route::delete('messages/{id}', [MessageController::class,'destroy']);
Route::put('message/{id}', [MessageController::class,'update']);




