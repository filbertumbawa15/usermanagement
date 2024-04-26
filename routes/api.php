<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ConfigModulAksesController;
use App\Http\Controllers\Api\LevelController;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('login', [AuthController::class, 'login']);

Route::middleware(['auth:api'])->group(function () {
    Route::resource('level', LevelController::class)->whereNumber('level');
    Route::get('checkaccessmodule', [ConfigModulAksesController::class, 'checkAccessModule']);
});
