<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\OperationController;
use App\Http\Controllers\InterventionController;
use App\Http\Controllers\VehiculeController;



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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [HomeController::class,'index'])->name('home');

Route::group(['middleware' => ['admin']], function () {
    Route::get('/admin', [HomeController::class, 'adminView'])->name('admin.view');
});

Route::resource('users', UserController::class);
Route::resource('interventions', InterventionController::class);
Route::resource('operations', OperationController::class);
Route::resource('vehicules', VehiculeController::class);

Route::get('/search',  [UserController::class, 'searchUser']);