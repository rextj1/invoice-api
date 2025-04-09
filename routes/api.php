<?php

use App\Http\Controllers\MediaUploadController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::group(['prefix' => 'v1', 'namespace' => 'App\Http\Controllers\Api\V1', 'middleware' => 'auth:sanctum'], function () {
    // apiResource omitts create and edit
    Route::apiResource('customers', CustomerController::class);
    Route::post('customers/bulkDelete', ['uses' => 'CustomerController@bulkDelete']);

    Route::apiResource('invoices', InvoiceController::class);
    
    Route::post('invoices/bulk', ['uses' => 'InvoiceController@bulkStore']);
});

Route::post('/uploadMedia', [MediaUploadController::class, 'uploadMedia']);
Route::get('/media', [MediaUploadController::class, 'getUploadedFiles']);




Route::get('/', function () {
    return view('welcome');
});