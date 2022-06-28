<?php

use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\ChoferController;
use App\Http\Controllers\BusRouteController;
use App\Http\Controllers\EntryPointController;
use App\Http\Controllers\ExitPointController;
use App\Http\Controllers\BusController;
use App\Http\Controllers\PhotoController;
use App\Http\Controllers\LocationController;


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

Route::post('/login',[UserController::class,'login']);
Route::post('/signup',[UserController::class,'signup']);

Route::middleware(['auth:sanctum'])->group(function () {
    Route::post('/user/authenticated', [UserController::class, 'authenticated']);
    Route::post('/logout', [UserController::class, 'logout']);
    Route::post('/logout_all', [UserController::class, 'logoutAll']);
    
    Route::prefix('user')->group(function () {
        Route::get('/',[UserController::class,'index']);
        Route::get('/{user}',[UserController::class,'show']);
        Route::post('/',[UserController::class,'store']);
        Route::put('/{user}',[UserController::class,'update']);
        Route::delete('/{user}',[UserController::class,'destroy']);
        Route::post('/restore',[UserController::class,'restore']);
    });

    Route::prefix('chofer')->group(function () {
        Route::get('/',[ChoferController::class,'index']);
        Route::get('/{chofer}',[ChoferController::class,'show']);
        Route::post('/',[ChoferController::class,'store']);
        Route::put('/{chofer}',[ChoferController::class,'update']);
        Route::delete('/{chofer}',[ChoferController::class,'destroy']);
        Route::post('/restore',[ChoferController::class,'restore']);
    });

    Route::prefix('busroute')->group(function () {
        Route::get('/',[BusRouteController::class,'index']);
        Route::get('/{busroute}',[BusRouteController::class,'show']);
        Route::post('/',[BusRouteController::class,'store']);
        Route::put('/{busroute}',[BusRouteController::class,'update']);
        Route::delete('/{busroute}',[BusRouteController::class,'destroy']);
        Route::post('/restore',[BusRouteController::class,'restore']);
    });

    Route::prefix('entrypoint')->group(function () {
        Route::get('/',[EntryPointController::class,'index']);
        Route::get('/{entrypoint}',[EntryPointController::class,'show']);
        Route::post('/',[EntryPointController::class,'store']);
        Route::put('/{entrypoint}',[EntryPointController::class,'update']);
        Route::delete('/{entrypoint}',[EntryPointController::class,'destroy']);
        Route::post('/restore',[EntryPointController::class,'restore']);
    });

    Route::prefix('exitpoint')->group(function () {
        Route::get('/',[ExitPointController::class,'index']);
        Route::get('/{exitpoint}',[ExitPointController::class,'show']);
        Route::post('/',[ExitPointController::class,'store']);
        Route::put('/{exitpoint}',[ExitPointController::class,'update']);
        Route::delete('/{exitpoint}',[ExitPointController::class,'destroy']);
        Route::post('/restore',[ExitPointController::class,'restore']);
    });

    Route::prefix('bus')->group(function () {
        Route::get('/',[BusController::class,'index']);
        Route::get('/{bus}',[BusController::class,'show']);
        Route::post('/',[BusController::class,'store']);
        Route::put('/{bus}',[BusController::class,'update']);
        Route::delete('/{bus}',[BusController::class,'destroy']);
        Route::post('/restore',[BusController::class,'restore']);
    });

    Route::prefix('photo')->group(function () {
        Route::get('/',[PhotoController::class,'index']);
        Route::get('/{photo}',[PhotoController::class,'show']);
        Route::post('/',[PhotoController::class,'store']);
        Route::put('/{photo}',[PhotoController::class,'update']);
        Route::delete('/{photo}',[PhotoController::class,'destroy']);
        Route::post('/restore',[PhotoController::class,'restore']);
    });

    Route::prefix('location')->group(function () {
        Route::get('/',[LocationController::class,'index']);
        Route::get('/{location}',[LocationController::class,'show']);
        Route::post('/',[LocationController::class,'store']);
        Route::put('/{location}',[LocationController::class,'update']);
        Route::delete('/{location}',[LocationController::class,'destroy']);
        Route::post('/restore',[LocationController::class,'restore']);
    });



    //Muestra de como usar las habilities
    Route::post('/test1', function () {
        return 'works';
    })->middleware('ability:user_store,administrator');
});