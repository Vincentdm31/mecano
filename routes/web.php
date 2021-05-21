<?php

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\InterventionController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\OperationController;
use App\Http\Controllers\OperationListController;
use App\Http\Controllers\PieceController;
use App\Http\Controllers\PieceListController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TimeInterventionController;
use App\Http\Controllers\TimeOperationController;
use App\Http\Controllers\VehiculeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VerifInterventionController;
use App\Models\Intervention;

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

    Route::get('/', [HomeController::class, 'index'])->name('home');
    Route::get('/home/user', [HomeController::class, 'userView'])->name('home.user');

    Route::get('/adminIntervention',  [InterventionController::class, 'adminIntervention'])->name('adminIntervention');
    Route::get('/goToIntervention',  [InterventionController::class, 'goToIntervention'])->name('goToIntervention');
    Route::get('/goToJoinIntervention',  [InterventionController::class, 'goToJoinIntervention'])->name('goToJoinIntervention');
    Route::get('/joinIntervention',  [InterventionController::class, 'joinIntervention'])->name('joinIntervention');
    Route::get('/leaveIntervention',  [InterventionController::class, 'leaveIntervention'])->name('leaveIntervention');
    Route::get('/resumeIntervention',  [InterventionController::class, 'resumeIntervention'])->name('resumeIntervention');
    Route::get('/exportPDF/{id}', [InterventionController::class, 'exportPDF'])->name('exportPDF');
    Route::get('/intervention/step1', [InterventionController::class, 'stepOne'])->name('stepOne');
    Route::get('/intervention/step2', [InterventionController::class, 'stepTwo'])->name('stepTwo');
    Route::get('/totalTime/{id}',  [InterventionController::class, 'totalTime'])->name('totalTime');
    Route::get('/totalTimeOp/{id}',  [OperationController::class, 'totalTimeOp'])->name('totalTimeOp');
    Route::get('/getVehicles',  [VehiculeController::class, 'getVehicles'])->name('getVehicles');
    Route::get('/home/factures', [VerifInterventionController::class, 'verifIntervention'])->name('home.facture');
    Route::get('/verifFull', [VerifInterventionController::class, 'verifFull'])->name('verifFull');



    Route::get('/searchIntervention',  [InterventionController::class, 'searchIntervention'])->name('searchIntervention');
    Route::get('/searchIntervVehicule',  [InterventionController::class, 'searchIntervVehicule'])->name('searchIntervVehicule');
    Route::get('/searchOperationsList',  [OperationListController::class, 'searchOperationsList']);
    Route::get('/searchPiecesList',  [PieceListController::class, 'searchPiecesList']);
    Route::get('/searchUser',  [UserController::class, 'searchUser']);
    Route::get('/searchVehicule',  [VehiculeController::class, 'searchVehicule']);
    Route::get('/searchInterventionFull',  [VerifInterventionController::class, 'searchInterventionFull'])->name('searchInterventionFull');
    Route::get('/searchInterventionVerif',  [VerifInterventionController::class, 'searchInterventionVerif'])->name('searchInterventionVerif');

    Route::post('/home/validateVerif/{id}', [VerifInterventionController::class, 'validateVerif'])->name('validateVerif');
    Route::post('/needMove',  [InterventionController::class, 'needMove'])->name('needMove');
    Route::post('/sendVerif/{id}', [InterventionController::class, 'sendVerif'])->name('sendVerif');
    
    Route::post('/joinOperation/{intervention}', [InterventionController::class, 'joinOperation'])->name('joinOperation');
    Route::put('/leaveOperation/{intervention}', [InterventionController::class, 'leaveOperation'])->name('leaveOperation');


    Route::resource('interventions', InterventionController::class);
    Route::resource('timeinterventions', TimeInterventionController::class);
    Route::resource('timeoperations', TimeOperationController::class);
    Route::resource('controller', Controller::class);
    Route::resource('pieces', PieceController::class);
    Route::resource('verif', VerifInterventionController::class);
    Route::resource('operations', OperationController::class);
    Route::resource('time', TimeInterventionController::class);


    Route::put('/editOperation/{id}{interventionId}', [OperationController::class, 'editOperation'])->name('editOperation');
    Route::put('/endOperation/{operationId}-{interventionId}-{state}', [OperationController::class, 'finish'])->name('finishOperation');
    Route::put('/selectVehicule',  [InterventionController::class, 'selectVehicule'])->name('selectVehicule');
    Route::put('/setDeplacement',  [InterventionController::class, 'setDeplacement'])->name('setDeplacement');
    Route::put('/setEndDeplacement',  [InterventionController::class, 'setEndDeplacement'])->name('setEndDeplacement');

    // Modify Intervention
    Route::resource('invoice', InvoiceController::class);
    Route::get('/editInvoice/{id}', [InterventionController::class, 'editInvoice'])->name('editInvoice');
    Route::put('/modifyInterventionDate/{id}', [InvoiceController::class, 'modifyInterventionDate'])->name('modifyInterventionDate');
    Route::put('/modifyDeplacement/{id}', [InvoiceController::class, 'modifyDeplacement'])->name('modifyDeplacement');
    Route::put('/modifyVehicule/{id}', [InvoiceController::class, 'modifyVehicule'])->name('modifyVehicule');
    Route::put('/modifyObservations/{id}', [InvoiceController::class, 'modifyObservations'])->name('modifyObservations');
    Route::put('/modifyPauseIntervention/{id}', [InvoiceController::class, 'modifyPauseIntervention'])->name('modifyPauseIntervention');
    Route::put('/modifyPauseOperation/{id}', [InvoiceController::class, 'modifyPauseOperation'])->name('modifyPauseOperation');
    Route::put('/modifyOperation/{id}', [InvoiceController::class, 'modifyOperation'])->name('modifyOperation');
    Route::put('/modifyPiece/{id}', [InvoiceController::class, 'modifyPiece'])->name('modifyPiece');
    
});
