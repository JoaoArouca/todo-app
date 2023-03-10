<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\UserController;

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
// Task
Route::post('/task/{user}', [TaskController::class, 'create']); // Create task for an user
Route::get('/task/{id}', [TaskController::class, 'read']); // read all tasks by user id
Route::put('/task/status/{id}', [TaskController::class, 'updateStatus']); // update status by task id
// User
Route::post('/user', [UserController::class, 'create']); // Create user
