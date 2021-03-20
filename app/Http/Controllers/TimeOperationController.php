<?php

namespace App\Http\Controllers;

use App\Models\Operation;
use App\Models\TimeOperation;
use Carbon\Carbon;
use Illuminate\Http\Request;

class TimeOperationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $inputs = $request->except('_token', 'intervention_id');
        $interventionID = $request->input('intervention_id');

        $operationId = $request->input('operation_id');
        $operation = Operation::find($operationId);

        if ($operation->state == 'doing') {
            $timer = new TimeOperation();

            foreach ($inputs as $key => $value) {
                $timer->$key = $value;
                $timer->save();
            }

            $operation->state = 'pause';
            $operation->save();
        } else if ($operation->state == 'pause') {
            $timer = TimeOperation::Where('operation_id', 'like', $operationId)->latest()->first();

            foreach ($inputs as $key => $value) {
                $timer->$key = $value;
                $timer->save();
            }

            $operation->state = 'doing';
            $operation->save();
        }

        return redirect(route('interventions.edit', ['intervention' => $interventionID]));
    }


    /**
     * Display the specified resource.
     *
     * @param  \App\Models\TimeOperation  $timeOperation
     * @return \Illuminate\Http\Response
     */
    public function show(TimeOperation $timeOperation)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\TimeOperation  $timeOperation
     * @return \Illuminate\Http\Response
     */
    public function edit(TimeOperation $timeOperation)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\TimeOperation  $timeOperation
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, TimeOperation $timeOperation)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\TimeOperation  $timeOperation
     * @return \Illuminate\Http\Response
     */
    public function destroy(TimeOperation $timeOperation)
    {
        //
    }

    public function totalTimeOp(Request $request)
    {

        $id = $request->input('operation_id');
        $dates = TimeOperation::Where('operation_id', 'like', $id)->whereNotNull('end_date')->get();
        $totaltime = 0;

        foreach ($dates as $date) {
            $timetoseconds = Carbon::parse($date->end_date)->diffInSeconds(Carbon::parse($date->start_date));
            $totaltime += $timetoseconds;
        }

        dd($totaltime);
    }
}
