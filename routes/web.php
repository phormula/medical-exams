<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\StructuresController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
Route::post('/addstructure', [DashboardController::class, 'store']);

Route::get('/getregions', [DashboardController::class,'getregions']);
Route::get('/getexams', [DashboardController::class,'getexams']);
Route::get('findStateWithRegionID/{id}', [DashboardController::class,'findStateWithRegionID']);
Route::get('findCityWithStateID/{id}', [DashboardController::class,'findCityWithStateID']);
Route::get('findZipWithCityID/{id}', [DashboardController::class,'findZipWithCityID']);

Route::get('/', [HomeController::class, 'search'])->name('search');

Auth::routes();


