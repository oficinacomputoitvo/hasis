<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\MaintenanceApiController;
use App\Http\Controllers\Api\ReceptionRequestController;
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
Route::group(['middleware' => 'administrator'], function () {
    Route::post('maintenances/save',[MaintenanceApiController::class, 'store']); 
    Route::post('maintenances/add-service',[MaintenanceApiController::class, 'addService']); 
    Route::post('receptions/save',[ReceptionRequestController::class, 'save']); 
});