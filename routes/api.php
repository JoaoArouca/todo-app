<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AuthController;
use App\Http\Middleware\AuthenticateSanctum;

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

Route::group(['middleware' => [AuthenticateSanctum::class]], function () {
    // Task
    Route::post('/task/{user_id}', [TaskController::class, 'create']); // Create task for an user
    Route::get('/task/{id}', [TaskController::class, 'read']); // read all tasks by user id
    Route::put('/task/status/{id}', [TaskController::class, 'updateStatus']); // update status by task id
    Route::put('/task/content/{id}', [TaskController::class, 'updateContent']); // update Content by task id
    Route::delete('/task/{id}', [TaskController::class, 'destroy']); // delete task by id

    //User
    Route::get('/user', [UserController::class, 'index']); // Read all users
});

// User
Route::post('/user', [UserController::class, 'create']); // Create user
Route::delete('/user/{id}', [UserController::class, 'destroy']); // delete user by id
// Login
Route::post('login', [AuthController::class, 'login']);
