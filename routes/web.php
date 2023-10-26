<?php

use App\Http\Controllers\DeveloperController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\DepartmentController;
use Maatwebsite\Excel\Facades\Excel;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/


Auth::routes(['register' => false]);


Route::group(['middleware' => ['auth']], function () {
    Route::get('/', [App\Http\Controllers\MyAppController::class, 'index']);
    Route::get('/dashboard', [App\Http\Controllers\DashboardController::class, 'index']);

    Route::resource('roles', RoleController::class);
    Route::resource('users', UserController::class);
    Route::resource('permissions', PermissionController::class);
    Route::resource('departments', DepartmentController::class);

    //Passsword
    Route::get('change_password', [App\Http\Controllers\UserController::class, 'editPassword']);
    Route::post('change_password', [App\Http\Controllers\UserController::class, 'updatePassword']);

    //Logs
    Route::get('/logs/audit_logs', [App\Http\Controllers\LogController::class, 'auditLogs'])->name('audit_logs.index');
    Route::delete('/audit_logs', [App\Http\Controllers\LogController::class, 'deleteAuditLogs']);

    Route::get('/logs/system_logs', [App\Http\Controllers\LogController::class, 'systemLogs'])->name('system_logs.index');
    Route::delete('/system_logs', [App\Http\Controllers\LogController::class, 'deleteSystemLogs']);

    //Settings
    Route::get('/user_settings', [App\Http\Controllers\SettingController::class, 'userSettings'])->name('user_settings.index');
    Route::get('/system_settings', [App\Http\Controllers\SettingController::class, 'systemSettings'])->name('system_settings.index');

    //Services
    Route::resource('/services', \App\Http\Controllers\ServiceController::class);

    //Dataset
    Route::resource('/datasets', \App\Http\Controllers\DatasetController::class);

    //Applications
    Route::controller(\App\Http\Controllers\ApplicationController::class)->group(function () {
        Route::resource('/applications', \App\Http\Controllers\ApplicationController::class);
        Route::group([
            'prefix' => 'applications/',
            'as' => 'applications.'
        ], function () {
            Route::get('/{id}/summary', 'summary')->name('summary');
            Route::get('/{id}/resources', 'resources')->name('resources');
            Route::get('/{id}/operations/{route_name}', 'operations')->name('operations'); // custom view components
            Route::get('/{id}/services', 'services')->name('services');
            Route::get('/{id}/logs', 'logs')->name('logs');
            Route::post('/{id}/datasets', 'store_application_dataset')->name('datasets.store');
            Route::get('{application}/clone-app', 'editClonedApplication');
        });

        Route::group([
            'prefix' => 'ajax/applications',
        ], function () {
            //Clone Applications
            Route::get('{id}/{action}', 'control');
            Route::post('{application}/load-state-control-component', 'loadStateControlComponent');
            Route::post('{application}/load-resource-usages-component', 'loadResourceUsagesComponent');
            Route::post('{application}/clone-app', 'cloneApplication');
        });
    });


    //My Apps
    Route::resource('/my-apps', \App\Http\Controllers\MyAppController::class);

    //Central dashboard
    Route::get('/central_dashboard', [App\Http\Controllers\DashboardController::class, 'central_dashboard']);

    //DcaMA
    Route::controller(\App\Http\Controllers\Custom\DcaMaController::class)->group(function () {
        Route::group([
            'prefix' => 'applications/{id}/operations/dca-ma/',
            'as' => 'dca_ma.'
        ], function () {
            Route::get('/tasks', 'tasks')->name('tasks');
            Route::get('/new_task', 'new_task')->name('new_task');
            Route::post('/new_task', 'store_new_task')->name('store_new_task');
            Route::get('/task/{task_id}/manual_labelling/{ref_id?}', 'manual_labelling')->name('manual_labelling');
            Route::get('/results/{ref_id}', 'results')->name('results');
            Route::post('/task/{task_id}/manual_labelling/{ref_id}', 'update_manual_labelling')->name('update_manual_labelling');
            Route::get('/task/{task_id}/report', 'report')->name('report');
        });
    });
    
    //ADC-PCB
    Route::controller(\App\Http\Controllers\Custom\AdcPcbController::class)->group(function () {
        Route::group([
            'prefix' => 'applications/{id}/operations/adc-pcb/',
            'as' => 'adc_pcb.'
        ], function () {
            Route::get('/tasks', 'tasks')->name('tasks');
            Route::get('/new_task', 'new_task')->name('new_task');
            Route::post('/new_task', 'store_new_task')->name('store_new_task');
            Route::get('/task/{task_id}/manual_labelling/{ref_id?}', 'manual_labelling')->name('manual_labelling');
            Route::get('/results/{ref_id}', 'results')->name('results');
            Route::post('/task/{task_id}/manual_labelling/{ref_id}', 'update_manual_labelling')->name('update_manual_labelling');
            Route::get('/task/{task_id}/report', 'report')->name('report');
        });
    });
});