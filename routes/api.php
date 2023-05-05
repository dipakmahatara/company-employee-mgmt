<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\EmployeeController;

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

Route::post('/auth/login', [AuthController::class, 'login']);

Route::get('/get-all-companies', [CompanyController::class, 'getAllCompanies']);
Route::apiResource('companies', CompanyController::class)->only(['index', 'store', 'show', 'update', 'destroy']);
Route::apiResource('employees', EmployeeController::class)->only(['index', 'store', 'show', 'update', 'destroy']);
// Route::apiResource('companies', CompanyController::class)->middleware('auth:sanctum');

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
