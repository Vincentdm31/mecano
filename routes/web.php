<?php

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\InterventionController;
use App\Http\Controllers\OperationController;
use App\Http\Controllers\OperationListController;
use App\Http\Controllers\PieceController;
use App\Http\Controllers\PieceListController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TimeInterventionController;
use App\Http\Controllers\TimeOperationController;
use App\Http\Controllers\VehiculeController;
use App\Http\Controllers\UserController;


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


Auth::routes(['register' => false]);

Route::group(['middleware' => ['storekeeper']], function () {
    Route::get('/home/storekeeper', [HomeController::class, 'storeKeeperView'])->name('home.storekeeper');
    Route::resource('piecesList', PieceListController::class);
});

Route::group(['middleware' => ['admin']], function () {
    Route::get('/home/admin', [HomeController::class, 'adminView'])->name('home.admin');
    Route::resource('users', UserController::class);
    Route::resource('operationsList', OperationListController::class);
});

Route::group(['middleware' => ['root']], function () {
    Route::get('/home/root', [HomeController::class, 'rootView'])->name('home.root');
    Route::resource('vehicules', VehiculeController::class);
});

Route::middleware('auth')->group(function () {

    Route::get('/home/user', [HomeController::class, 'userView'])->name('home.user');

    Route::get('/', [HomeController::class, 'index'])->name('home');

    Route::resource('interventions', InterventionController::class);
    Route::resource('timeinterventions', TimeInterventionController::class);
    Route::resource('timeoperations', TimeOperationController::class);
    Route::resource('controller', Controller::class);
    Route::resource('pieces', PieceController::class);


    // User
    Route::get('/searchUser',  [UserController::class, 'searchUser']);


    // Intervention
    Route::get('/resumeIntervention',  [InterventionController::class, 'resumeIntervention'])->name('resumeIntervention');
    Route::get('/joinIntervention',  [InterventionController::class, 'joinIntervention'])->name('joinIntervention');
    Route::get('/goToIntervention',  [InterventionController::class, 'goToIntervention'])->name('goToIntervention');
    Route::get('/goToJoinIntervention',  [InterventionController::class, 'goToJoinIntervention'])->name('goToJoinIntervention');
    Route::get('/leaveIntervention',  [InterventionController::class, 'leaveIntervention'])->name('leaveIntervention');
    Route::get('/searchIntervVehicule',  [InterventionController::class, 'searchIntervVehicule'])->name('searchIntervVehicule');
    Route::put('/selectVehicule',  [InterventionController::class, 'selectVehicule'])->name('selectVehicule');
    Route::post('/needMove',  [InterventionController::class, 'needMove'])->name('needMove');
    Route::put('/setDeplacement',  [InterventionController::class, 'setDeplacement'])->name('setDeplacement');
    Route::put('/setEndDeplacement',  [InterventionController::class, 'setEndDeplacement'])->name('setEndDeplacement');
    Route::get('/adminIntervention',  [InterventionController::class, 'adminIntervention'])->name('adminIntervention');
    Route::get('/exportPDF/{id}', [InterventionController::class, 'exportPDF'])->name('exportPDF');


    // Stepper Intervention
    Route::get('/intervention/step1', [InterventionController::class, 'stepOne'])->name('stepOne');
    Route::get('/intervention/step2', [InterventionController::class, 'stepTwo'])->name('stepTwo');

    // Timer Intervention
    Route::resource('time', TimeInterventionController::class);
    Route::post('/totalTime',  [TimeInterventionController::class, 'totalTime'])->name('totalTime');

    Route::get('/totalTimeOp/{id}',  [OperationController::class, 'totalTimeOp'])->name('totalTimeOp');

    // Véhicule
    Route::get('/searchVehicule',  [VehiculeController::class, 'searchVehicule']);
    Route::get('/getVehicles',  [VehiculeController::class, 'getVehicles'])->name('getVehicles');

    //PieceList
    Route::get('/searchPiecesList',  [PieceListController::class, 'searchPiecesList']);

    //Operation
    Route::resource('operations', OperationController::class);
    Route::put('/editOperation/{id}{interventionId}', [OperationController::class, 'editOperation'])->name('editOperation');
    Route::get('/searchOperationsList',  [OperationListController::class, 'searchOperationsList']);

    Route::get('/totalTimeIntervention/{id}', [InterventionController::class, 'totalTime'])->name('totalTimeIntervention');

    Route::put('/endOperation/{operationId}-{interventionId}-{state}', [OperationController::class, 'finish'])->name('finishOperation');
});
