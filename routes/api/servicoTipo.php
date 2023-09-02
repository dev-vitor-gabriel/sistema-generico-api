<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\ServicoTipoController;

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

Route::controller(ServicoTipoController::class)->group(function () {
    Route::post('create', 'create');
    Route::get('getAll', 'getAll');
    Route::post('getById', 'getById');
    Route::post('updateServiceType', 'updateServiceType');
    Route::post('deleteServiceType', 'deleteServiceType');
});