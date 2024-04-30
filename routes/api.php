<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ConfigModulAksesController;
use App\Http\Controllers\Api\ConfigModulMenuController;
use App\Http\Controllers\Api\ConfigModulLevelAksesController;
use App\Http\Controllers\Api\LevelController;
use App\Http\Controllers\Api\ModulController;
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
    Route::resource('level', LevelController::class)->whereUuid('level');
    Route::get('checkaccessmodule/{id}', [ConfigModulAksesController::class, 'checkAccessModule']);
    Route::get('getmenu', [ConfigModulMenuController::class, 'getMenu']);
    Route::get('configmodullevelakses/haspermission', [ConfigModulLevelAksesController::class, 'hasPermission']);

    Route::get('getmodulbylevel', [ModulController::class, 'getModulByLevel']);
    Route::resource('modul', ModulController::class)->whereUuid('modul');
    
    Route::get('menu/get', [ConfigModulMenuController::class, 'get']);
    Route::resource('menu', ConfigModulMenuController::class)->whereUuid('menu');

    Route::get('getlevelaksesbymodul', [ConfigModulLevelAksesController::class, 'getLevelAksesByModul']);
    Route::resource('levelakses', ConfigModulLevelAksesController::class)->whereUuid('levelakses');
});
