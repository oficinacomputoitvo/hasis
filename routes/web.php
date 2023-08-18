<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthenticateController;
use App\Http\Controllers\AreaController;
use App\Http\Controllers\SoftwareController;
use App\Http\Controllers\ReceptionOfRequestController;
use App\Http\Controllers\ExecutionOfServiceController;
use App\Http\Controllers\HardwareController;
use App\Http\Controllers\WorkOrderController;

use App\Http\Controllers\MaintenanceController;
use App\Http\Controllers\ServicerequestController;
use App\Http\Controllers\TemplateController;
use App\Http\Controllers\DashboardController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::fallback(function () {
    return view('errors.404');
});


Route::get('maintenances/preview', function () {
    return view('errors.404');
});


Route::post('maintenances/preview', [MaintenanceController::class, 'preview'])->name('maintenances.preview');


Route::group(['middleware' => 'approver'], function () {
    Route::get('workorders/listxapprove', [WorkOrderController::class, 'listxapprove'])->name('workorders.listxapprove');
    Route::post('workorders/approve', [WorkOrderController::class,'approve'])->name('workorders.approve');
});


Route::group(['middleware' => 'administrator'], function () {

    Route::get('registration', [AuthenticateController::class, 'registration'])->name('register-user');
    
    Route::resource('areas', AreaController::class);

    Route::resource('softwares', SoftwareController::class);
    
    Route::resource('hardwares', HardwareController::class);

    Route::resource('maintenances', MaintenanceController::class);

    Route::resource('receptionrequests',ReceptionOfRequestController::class);

    Route::resource('executionofservices',ExecutionOfServiceController::class);

    Route::get('workorders/preview', [WorkOrderController::class, 'preview'])->name('workorders.preview');

    Route::resource('templates',TemplateController::class);

  
});

Route::group(['middleware' => 'requester'], function () {
    
    Route::post('servicerequests/cancel', [ServicerequestController::class,'cancel'])->name('servicerequests.cancel');
    
    Route::get('servicerequests/preview/{servicerequest}', [ServicerequestController::class, 'preview'])->name('servicerequests.preview');
    
    Route::resource('servicerequests', ServicerequestController::class);
    
    Route::get('workorders/listxrelease', [WorkOrderController::class, 'listxrelease'])->name('workorders.listxrelease');

    Route::post('workorders/release', [WorkOrderController::class,'release'])->name('workorders.release');

    Route::get('registerrequests', [AuthenticateController::class, 'registerrequest'])->name('registerrequests');



});



Route::get('/', function () {
    return view('auth.login');
});

Route::get('/login', function () {
    return view('auth.login');
});


Route::get('login', [AuthenticateController::class, 'index'])->name('login');
Route::get('dashboards', [DashboardController::class, 'show'])->name("dashboards"); 
Route::post('custom-login', [AuthenticateController::class, 'customLogin'])->name('login.custom'); 
Route::post('custom-registration', [AuthenticateController::class, 'customRegistration'])->name('register.custom'); 
Route::get('signout', [AuthenticateController::class, 'signOut'])->name('signout');
Route::get('workorders/preview', [WorkOrderController::class, 'preview'])->name('workorders.preview');

