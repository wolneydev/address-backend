<?php

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
Route::apiResource('users', App\Http\Controllers\UserController::class)->middleware(['transaction']);


Route::prefix('auth')->group(function () {
    Route::post('login', [App\Http\Controllers\LoginController::class, 'login']);
    Route::post('logout', [App\Http\Controllers\LoginController::class, 'logout']);
});

//Route::get('autenticar',[App\Http\Controllers\RegisterController::class,'verifyPermission']);

 
 Route::apiResource('inspections',App\Http\Controllers\InspectionController::class);

 Route::post('sendmail',[App\Http\Controllers\MailController::class,'enviarEmail']);
 
;
 
 Route::apiResource('addresses',App\Http\Controllers\AddressController::class)->parameters([
    'token' => 'token']);
 

 
 Route::apiResource('transacaos',App\Http\Controllers\TransacaoController::class);
 
 Route::apiResource('transacaos',App\Http\Controllers\TransacaoController::class)->middleware(['transaction']);
 
 Route::apiResource('transacaos',App\Http\Controllers\TransacaoController::class)->middleware(['transaction']);
 
 Route::apiResource('transacaos',App\Http\Controllers\TransacaoController::class)->middleware(['transaction']);
 
 Route::apiResource('transacaos',App\Http\Controllers\TransacaoController::class)->middleware(['transaction']);
 
 Route::apiResource('transacaos',App\Http\Controllers\TransacaoController::class)->middleware(['transaction']);
 
 Route::apiResource('transacaos',App\Http\Controllers\TransacaoController::class)->middleware(['transaction']);
 
 Route::apiResource('transacaos',App\Http\Controllers\TransacaoController::class)->middleware(['transaction']);
 
 Route::apiResource('transacaos',App\Http\Controllers\TransacaoController::class)->middleware(['transaction']);
 
 Route::apiResource('transacaos',App\Http\Controllers\TransacaoController::class)->middleware(['transaction']);
 
 Route::apiResource('transacaos',App\Http\Controllers\TransacaoController::class)->middleware(['transaction']);
 
 Route::apiResource('subways',App\Http\Controllers\SubwayController::class)->middleware(['transaction']);
 
 Route::apiResource('subwaylines',App\Http\Controllers\SubwayLinesController::class)->middleware(['transaction']);
 
 Route::apiResource('books',App\Http\Controllers\BookController::class)->middleware(['transaction']);
 
 Route::apiResource('carros',App\Http\Controllers\CarroController::class)->middleware(['transaction']);