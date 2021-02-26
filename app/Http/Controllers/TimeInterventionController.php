<?php

namespace App\Http\Controllers;

use App\Models\Categorie;
use App\Models\Intervention;
use App\Models\TimeIntervention;
use App\Models\Vehicule;
use Carbon\Carbon;
use Illuminate\Http\Request;
use SebastianBergmann\Environment\Console;

class TimeInterventionController extends Controller
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
        $inputs = $request->except('_method', '_token');
        $vehicules = Vehicule::all();
        $categories = Categorie::all();
        $interventionID = $request->input('intervention_id');
        $intervention = Intervention::find($interventionID);
        if ($intervention->state == "doing") {
            $timer = new TimeIntervention();
            foreach ($inputs as $key => $value) {
                $timer->$key = $value;
                $timer->save();
            }
            $intervention->state = "pause";
            $intervention->save();
        } else if ($intervention->state == "pause") {
            $timer = TimeIntervention::Where('intervention_id', 'like', $interventionID)->latest()->first();
            foreach ($inputs as $key => $value) {
                $timer->$key = $value;
                $timer->save();
            }
            $intervention->state = "doing";
            $intervention->save();
        }


        return redirect(route('interventions.edit', ['intervention' => $intervention, 'vehicules' => $vehicules, 'categories' => $categories]));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\TimeIntervention  $timeIntervention
     * @return \Illuminate\Http\Response
     */
    public function show(TimeIntervention $timeIntervention)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\TimeIntervention  $timeIntervention
     * @return \Illuminate\Http\Response
     */
    public function edit(TimeIntervention $timeIntervention)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\TimeIntervention  $timeIntervention
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, TimeIntervention $timeIntervention)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\TimeIntervention  $timeIntervention
     * @return \Illuminate\Http\Response
     */
    public function destroy(TimeIntervention $timeIntervention)
    {
        //
    }

    
    public function totalTime(Request $request){

        $id = $request->input('intervention_id');
        $dates = TimeIntervention::Where('intervention_id', 'like', $id)->get();
        $totaltime = 0;

        foreach ($dates as $date){
            $timetoseconds = Carbon::parse($date->end_date)->diffInSeconds(Carbon::parse($date->start_date));
            $totaltime += $timetoseconds;
        }

        echo($totaltime);
    }
}
