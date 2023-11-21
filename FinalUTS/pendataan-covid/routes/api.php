<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PatientsController;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/patients',[PatientsController::class,'index']);
    Route::post('/patients', [PatientsController::class,'store']);
    Route::put('/patients/{id}', [PatientsController::class,'update']);
    Route::get('/patients/{id}', [PatientsController::class,'show']);
    Route::delete('/patients/{id}', [PatientsController::class,'destroy']);
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});
Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::post('/register', [AuthController::class, 'register'])->name('register');
