<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthController;

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
Route::middleware('api')
->prefix('auth')
->group(base_path('routes/api/auth.php'));

Route::middleware('api')
->prefix('servico')
->group(base_path('routes/api/servico.php'));

Route::middleware('api')
->prefix('servicoTipo')
->group(base_path('routes/api/servicoTipo.php'));

Route::middleware('api')
->prefix('material')
->group(base_path('routes/api/material.php'));

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

