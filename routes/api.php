<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ProjectController;
use App\Http\Controllers\Api\TaskController;
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



Route::apiResource('projects', ProjectController::class);

Route::prefix('projects/{id}')->group(function (){
    Route::get   ('/tasks'           , [TaskController::class, 'index']);
    Route::post  ('/tasks'           , [TaskController::class, 'store']);
    Route::get   ('/tasks/{taskId}'  , [TaskController::class, 'show']);
    Route::put   ('/tasks/{taskId}'  , [TaskController::class, 'update']);
    Route::delete('/tasks/{taskId}'  , [TaskController::class, 'destroy']);
});

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    Route::post('/logout', [AuthController::class, 'logout']);
});

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
