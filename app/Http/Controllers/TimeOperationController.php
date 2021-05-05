<?php

namespace App\Http\Controllers;

use App\Models\Operation;
use App\Models\TimeOperation;
use Carbon\Carbon;
use Illuminate\Http\Request;

class TimeOperationController extends Controller
{
    public function store(Request $request)
    {
        $inputs = $request->except('_token', 'intervention_id');
        $interventionID = $request->input('intervention_id');

        $operationId = $request->input('operation_id');
        $operation = Operation::find($operationId);

        if ($operation->state == 'doing') {

            $timer = new TimeOperation();
            $operation->state = 'pause';
        } else if ($operation->state == 'pause') {

            $timer = TimeOperation::Where('operation_id', 'like', $operationId)->latest()->first();
            $operation->state = 'doing';
        }

        foreach ($inputs as $key => $value) {
            $timer->$key = $value;
            $timer->save();
        }
        $operation->save();

        return redirect(route('interventions.edit', ['intervention' => $interventionID]));
    }
}
