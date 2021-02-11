<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\InterventionController;
use App\Http\Controllers\TimeInterventionController;
use App\Http\Controllers\VehiculeController;
use App\Http\Controllers\ImageUploaderController;
use Illuminate\Support\Facades\Auth;

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


Auth::routes();

Route::group(['middleware' => ['admin']], function () {
    Route::get('/admin', [HomeController::class, 'adminView'])->name('admin.view');
});

Route::middleware('auth')->group(function() {
    Route::get('/', [HomeController::class,'index'])->name('home');
    Route::resource('users', UserController::class);
    Route::resource('interventions', InterventionController::class);
    Route::resource('vehicules', VehiculeController::class);
    Route::resource('timeinterventions', TimeInterventionController::class);
    Route::resource('images', ImageUploaderController::class);

    Route::get('/searchUser',  [UserController::class, 'searchUser']);
    Route::get('/searchVehicule',  [VehiculeController::class, 'searchVehicule']);
    Route::get('/selectVehicule',  [InterventionController::class, 'selectVehicule'])->name('selectVehicule');

    Route::post('/addOperation',  [InterventionController::class, 'addOperation'])->name('addOperation');
    Route::put('/editOperation',  [InterventionController::class, 'editOperation'])->name('editOperation');
    Route::put('/deleteOperation',  [InterventionController::class, 'deleteOperation'])->name('deleteOperation');

    Route::post('/addPiece',  [InterventionController::class, 'addPiece'])->name('addPiece');
    Route::put('/editPiece',  [InterventionController::class, 'editPiece'])->name('editPiece');
    Route::put('/deletePiece',  [InterventionController::class, 'deletePiece'])->name('deletePiece');

});