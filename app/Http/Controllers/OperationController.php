<?php

namespace App\Http\Controllers;

use App\Models\Intervention;
use App\Models\Operation;
use App\Models\PieceList;
use App\Models\TimeOperation;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class OperationController extends Controller
{
    public function store(Request $request)
    {
        $inputs = $request->except('_method', '_token');
        $intervention_id = $request->intervention_id;

        $operation = new Operation();

        foreach ($inputs as $key => $value) {
            $operation->$key = $value;
        }

        $operation->start_operation_time = Carbon::now();
        $operation->user_id = Auth()->user()->id;

        $operation->save();

        $user = User::find(Auth()->user()->id);
        $user->actual_operation = $operation->id;
        $user->save();

        return redirect(route('interventions.edit', ['intervention' => $intervention_id]))->with(['toast' => 'addOperation', 'opState' => 'notEnd']);
    }

    public function update(Request $request, $id)
    {
        $inputs = $request->except('_token', '_method', 'updated_at');
        $interventionId = $request->intervention_id;
        $intervention = Intervention::find($interventionId);
        $operation = Operation::find($id);

        foreach ($inputs as $key => $value) {
            $operation->$key = $value;
        }

        $operation->save();

        $user = User::find(Auth()->user()->id);
        $user->actual_operation = $operation->id;
        $user->save();

        return redirect(route('interventions.edit', ['intervention' => $intervention->id]))->with(['toast' => 'update']);
    }

    public function destroy(Request $request, $id)
    {
        $intervention = $request->intervention_id;

        $operation = Operation::find($id);

        foreach ($operation->pieces as $piece) {
            $pieceId = $piece->piece_id;
            $pieceList = PieceList::find($pieceId);

            $pieceList->qte += $piece->qte;
            $pieceList->save();
        }

        $operation->delete();

        $user = User::find(Auth()->user()->id);
        $user->actual_operation = null;
        $user->save();

        return redirect(route('interventions.edit', ['intervention' => $intervention]))->with('toast', 'removeOperation');
    }

    public function editOperation($id, $interventionId)
    {
        $operation = Operation::find($id);
        $intervention = Intervention::find($interventionId);
        $timeOperation = new TimeOperation();

        $timeOperation->operation_id = $id;
        $timeOperation->start_date = $operation->end_operation_time;
        $timeOperation->end_date = Carbon::now();

        $timeOperation->save();

        $operation->state = 'doing';
        $operation->end_operation_time = null;

        $operation->save();

        $operationsList = Operation::where('state', 'doing')->get();

        foreach ($operationsList as $op) {
            $op->state = 'pause';
            $op->save();
        }

        return redirect(route('interventions.edit', ['intervention' => $intervention->id]))->with('toast', 'editOperation');
    }

    public function finish(Request $request, $operationId, $interventionId, $state)
    {
        $intervention = Intervention::find($interventionId);
        $operation = Operation::find($operationId);
        $endOperationTime = Carbon::now();

        $operation->state = $state;
        $operation->end_operation_time = $endOperationTime;

        $operation->save();

        $user = User::find(Auth()->user()->id);
        $user->actual_operation = null;
        $user->save();

        return redirect(route('interventions.edit', ['intervention' => $intervention->id]))->with(['toast' => 'update']);
    }
}
