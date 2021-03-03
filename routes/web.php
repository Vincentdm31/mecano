<?php

use App\Http\Controllers\CategorieController;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\InterventionController;
use App\Http\Controllers\TimeInterventionController;
use App\Http\Controllers\VehiculeController;
use App\Http\Controllers\ImageUploaderController;
use App\Http\Controllers\PieceController;
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

    Route::resource('users', UserController::class);
    Route::get('/searchUser',  [UserController::class, 'searchUser']);

    Route::resource('vehicules', VehiculeController::class);
    Route::get('/searchVehicule',  [VehiculeController::class, 'searchVehicule']);
    Route::get('/selectVehicule',  [InterventionController::class, 'selectVehicule'])->name('selectVehicule');

    Route::resource('pieces', PieceController::class);
    Route::get('/searchPiece',  [PieceController::class, 'searchPiece']);

    Route::resource('categories', CategorieController::class);
    Route::get('/searchCategorie',  [CategorieController::class, 'searchCategorie']);

});

Route::middleware('auth')->group(function () {
    Route::get('/', [HomeController::class, 'index'])->name('home');
    Route::resource('interventions', InterventionController::class);
    Route::get('/resumeIntervention',  [InterventionController::class, 'resumeIntervention'])->name('resumeIntervention');
    Route::get('/joinIntervention',  [InterventionController::class, 'joinIntervention'])->name('joinIntervention');
    Route::get('/goToIntervention',  [InterventionController::class, 'goToIntervention'])->name('goToIntervention');
    Route::get('/goToJoinIntervention',  [InterventionController::class, 'goToJoinIntervention'])->name('goToJoinIntervention');
    Route::get('/leaveIntervention',  [InterventionController::class, 'leaveIntervention'])->name('leaveIntervention');

    Route::resource('timeinterventions', TimeInterventionController::class);

    Route::post('/addOperation',  [InterventionController::class, 'addOperation'])->name('addOperation');
    Route::put('/editOperation',  [InterventionController::class, 'editOperation'])->name('editOperation');
    Route::put('/deleteOperation',  [InterventionController::class, 'deleteOperation'])->name('deleteOperation');

    Route::post('/addPiece',  [InterventionController::class, 'addPiece'])->name('addPiece');
    Route::put('/editPiece',  [InterventionController::class, 'editPiece'])->name('editPiece');
    Route::put('/deletePiece',  [InterventionController::class, 'deletePiece'])->name('deletePiece');

    Route::resource('controller', Controller::class);
    Route::get('/getVehicules',  [VehiculeController::class, 'getVehicules'])->name('getVehicules');

    Route::resource('time', TimeInterventionController::class);
    Route::post('/totalTime',  [TimeInterventionController::class, 'totalTime'])->name('totalTime');





});
