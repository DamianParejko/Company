<?php

use App\Http\Controllers\Api\V1\CompanyController;
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

Route::controller(CompanyController::class)->group(function (){
    Route::prefix('/company')->group(function () {
        Route::get('/', 'index');
        Route::get('/{id}', 'get');
        Route::post('/', 'create');
        Route::put('/{id}', 'update');
        Route::delete('/{id}', 'delete');
    });
<<<<<<< HEAD
});

Route::controller(WorkerController::class)->group(function (){
    Route::prefix('/workers')->group(function () {
        Route::get('/{id}', 'get');
        Route::post('/', 'create');
        Route::put('/{id}', 'update');
        Route::delete('/{id}', 'delete');
    });
=======
>>>>>>> fdd2a2bd4109dbb5cdf2f995be735049ea136d1d
});