<?php

use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\DashboardController;
use App\Http\Controllers\API\ProjectController;
use App\Http\Controllers\API\TaskController;
use App\Http\Controllers\API\TestController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use PHPUnit\Metadata\Test;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

/*
Route::get('/test', function() {
    return response()->json(['message'=>'Message from test AP']);
});
*/

Route::get('/test', [TestController::class, 'index']);


Route::apiResource('projects',  ProjectController::class)->middleware('auth:sanctum');
Route::apiResource('tasks',     TaskController::class)->middleware('auth:sanctum');


Route::post('/register',[AuthController::class, 'register'  ]); // Register API
Route::post('/login',   [AuthController::class, 'login'     ]); // Login API
Route::post('/logout',  [AuthController::class, 'logout'    ])->middleware('auth:sanctum'); // Logout API

Route::get('/dashboard-stats',[DashboardController::class, 'stats'])->middleware('auth:sanctum');