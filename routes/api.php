<?php

use App\HTTP\Controllers\AuthController;
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
// Public Routes

Route::post('/register',[AuthController::class,'register']);
Route::post('/login',[AuthController::class,'login']); 

// Private Routes
Route::group(['middleware'=> ['auth:sanctum']], function() {
    Route::post('/logout', [AuthController::class,'logout']);
    Route::post('/user', [AuthController::class,'user']);
});

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
