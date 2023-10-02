<?php

use App\Http\Controllers\ClienteController;
use App\Http\Controllers\ConsultorController;
use App\Http\Controllers\RelatorioController;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/consultores', [ConsultorController::class, 'index']);
Route::get('/table-details-consultant', [ConsultorController::class, 'calcularRelatorio']);
Route::get('/chart-details-consultant', [ConsultorController::class, 'obterGraficoReceitaLiquida']);

//TODO - Routes about client
Route::get('/clientes', [ClienteController::class, 'index']);
Route::get('/table-details-client', [ClienteController::class, 'gerarTabelaCliente']);
Route::get('/chart-details-client', [ClienteController::class, 'gerarGraficoCliente']);


Route::get('/dashboard', [RelatorioController::class, 'resumoDashboard']);
