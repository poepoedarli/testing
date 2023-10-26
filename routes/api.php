<?php

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware('auth:sanctum')->group(function () {
    // get_job_list
    Route::get('/get-tasks', [\App\Http\Controllers\API\ApplicationTaskController::class, 'getTaskList']);

    //DCA-MA
    Route::controller(\App\Http\Controllers\API\Custom\DcaMaController::class)->group(function () {
        Route::group([
            'prefix' => '/dca-ma/',
        ], function () {
            // dataset/insertImg
            Route::post('store-reference', 'createReference');
            // dataset/list
            Route::get('get-references', 'getReferences');
            // data_set_result
            Route::post('store-results', 'createResults');
        });
    });

    //ADC-PCB
    Route::controller(\App\Http\Controllers\API\Custom\AdcPcbController::class)->group(function () {
        Route::group([
            'prefix' => '/adc-pcb/',
        ], function () {
            // dataset/insertImg
            Route::post('store-reference', 'createReference');
            // dataset/list
            Route::get('get-references', 'getReferences');
            // data_set_result
            Route::post('store-results', 'createResults');
        });
    });

    // cloned-app list
    Route::get('/applications/get-applications/{state?}', [\App\Http\Controllers\API\ApplicationController::class, 'getApplications']);

    //after created containers or when XH detect the changes at containers [real-time data]
    Route::post('/applications/update-state', [\App\Http\Controllers\API\ApplicationController::class, 'updateState']);

    //Every hour, XH will call this API to update
    Route::post('/applications/update-resource-usage', [\App\Http\Controllers\API\ApplicationController::class, 'updateResourcesUsage']);

    //every second, XH will call this API to get the new Jobs
    Route::get('/jobs/list', [\App\Http\Controllers\API\BackendJobController::class, 'list']);

    //after XH received the new JOB and should call this API to mark as done
    Route::post('/jobs/mark-as-done', [\App\Http\Controllers\API\BackendJobController::class, 'markAsDone']);
});

// to create Auth Token
Route::post('/create/token', [\App\Http\Controllers\API\AuthController::class, 'createToken'])->withoutMiddleware('auth:sanctum');