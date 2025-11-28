<?php

use Illuminate\Auth\Events\Login;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PremiumController;
use App\Http\Controllers\CourseController;

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

Route::post('/login', [AuthController::class, 'login']);
Route::post('/store', [AuthController::class, 'store']);
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');

Route::group(['middleware' => 'auth:sanctum'], function () {
    Route::post('/premium-subscription', [PremiumController::class, 'store'])->middleware('auth:sanctum');
    Route::get('/courses', [CourseController::class, 'index'])->middleware('auth:sanctum');
    Route::get('/courses/{id}', [CourseController::class, 'show'])->middleware('auth:sanctum');
    Route::post('/courses/annotate', [CourseController::class, 'annotate'])->middleware('auth:sanctum');
    Route::put('/courses/annotate/edit', [CourseController::class, 'annotationEdit'])->middleware('auth:sanctum');
    Route::delete('/courses/annotate/delete', [CourseController::class, 'deleteAnnotation'])->middleware('auth:sanctum');
});
