<?php

use App\Models\Structure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Spatie\Activitylog\Models\Activity;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ExamController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\StructureController;
use App\Http\Controllers\ExamStructureController;

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

// Public routes
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::get('/exams', [ExamController::class, 'index']);

Route::apiResource('structures', StructureController::class)->only(['index', 'show']);
Route::get('/structures/search/{string}', [StructureController::class, 'search']);


// Protected routes
Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::apiResource('structures', StructureController::class)->only(['store']);

    Route::middleware(['manage.stucture'])->group(function () {
        Route::apiResource('/structures', StructureController::class)->only(['destroy', 'update']);

        Route::post('/structures-exam/{structure}', [ExamStructureController::class, 'store']);
        Route::delete('/structures-exam/{structure}', [ExamStructureController::class, 'destroy']);
    });

    Route::get('/user/structures/{usersId}', [StructureController::class, 'userStructure']);

    Route::post('/exams', [ExamController::class, 'store']);
    Route::put('/exams/{exam}', [ExamController::class, 'update']);

    Route::get('/activity', function () {
        return Activity::all();
    });

    Route::post('/logout', [AuthController::class, 'logout']);
});



Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
