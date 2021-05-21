<?php

namespace App\Http\Controllers;

use App\Models\Intervention;
use App\Models\Operation;
use App\Models\Piece;
use App\Models\TimeIntervention;
use App\Models\TimeOperation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class InvoiceController extends Controller
{
    public function edit($id){
        $intervention = Intervention::find($id);
        $operations = $intervention->operations()->get();
        $pausesInterventions = TimeIntervention::where('intervention_id', $id)->get();

        $operationsId = [];

        foreach($operations as $op){
            array_push($operationsId, $op->id);
        }

        $pausesOperations = TimeOperation::where('operation_id', $operationsId )->get();

        return view('interventions.modifyIntervention', ['intervention' => $intervention, 'operations' => $operations, 'pauseInterventions' => $pausesInterventions, 'pauseOperations' => $pausesOperations]);
    }

    public function modifyInterventionDate(Request $request, $id){
        $intervention = Intervention::find($id);
        $inputs = $request->except('_token', '_method');
        
        $validator = Validator::make($inputs, [
            'start_intervention_time' => 'date_format:Y-m-d H:i:s|required',
            'end_intervention_time' => 'date_format:Y-m-d H:i:s|required',
        ]);
 
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        foreach($inputs as $key=>$value){
            $intervention->$key = $value;
        }

        $intervention->save();

        return back();
    }

    public function modifyDeplacement(Request $request, $id){
        $intervention = Intervention::find($id);
        $inputs = $request->except('_token', '_method');
        
        $validator = Validator::make($inputs, [
            'start_move_begin' => 'date_format:Y-m-d H:i:s|required',
            'end_move_begin' => 'date_format:Y-m-d H:i:s|required',
            'start_move_return' => 'date_format:Y-m-d H:i:s|required',
            'end_move_return' => 'date_format:Y-m-d H:i:s|required',
        ]);
 
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        foreach($inputs as $key=>$value){
            $intervention->$key = $value;
        }
        $intervention->needMove = true;
        $intervention->save();

        return back();
    }

    public function modifyVehicule(Request $request, $id){
        $intervention = Intervention::find($id);
        $inputs = $request->except('_token', '_method');
        
        $validator = Validator::make($inputs, [
            'km_vehicule' => 'integer|required',
        ]);
 
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        foreach($inputs as $key=>$value){
            $intervention->$key = $value;
        }

        $intervention->save();

        return back();
    }

    public function modifyObservations(Request $request, $id){
        $intervention = Intervention::find($id);
        $inputs = $request->except('_token', '_method');
        
        $validator = Validator::make($inputs, [
            'observations' => 'string|nullable',
        ]);
 
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        foreach($inputs as $key=>$value){
            $intervention->$key = $value;
        }

        $intervention->save();

        return back();
    }

    public function modifyPauseIntervention(Request $request, $id){
        $pauseIntervention = TimeIntervention::find($id);
        $inputs = $request->except('_token', '_method');
        
        $validator = Validator::make($inputs, [
            'start_date' => 'date_format:Y-m-d H:i:s|required',
            'end_date' => 'date_format:Y-m-d H:i:s|required',
        ]);
 
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        foreach($inputs as $key=>$value){
            $pauseIntervention->$key = $value;
        }

        $pauseIntervention->save();

        return back();
    }

    public function modifyPauseOperation(Request $request, $id){
        $pausesOperation = TimeOperation::find($id);
        $inputs = $request->except('_token', '_method');
        
        $validator = Validator::make($inputs, [
            'start_date' => 'date_format:Y-m-d H:i:s|required',
            'end_date' => 'date_format:Y-m-d H:i:s|required',
        ]);
 
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        foreach($inputs as $key=>$value){
            $pausesOperation->$key = $value;
        }

        $pausesOperation->save();

        return back();
    }

    public function modifyOperation(Request $request, $id){
        $operation = Operation::find($id);
        $inputs = $request->except('_token', '_method');
        
        $validator = Validator::make($inputs, [
            'start_operation_time' => 'date_format:Y-m-d H:i:s|required',
            'end_operation_time' => 'date_format:Y-m-d H:i:s|required',
        ]);
 
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        foreach($inputs as $key=>$value){
            $operation->$key = $value;
        }

        $operation->save();

        return back();
    }

    public function modifyPiece(Request $request, $id){
        $piece = Piece::find($id);

        $inputs = $request->except('_token', '_method');
        
        $validator = Validator::make($inputs, [
            'piece_id' => 'integer|required',
            'qte' => 'integer|nullable',
        ]);
 
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $piece->qte = $request->qte;

        $piece->save();

        return back();
    }
}
