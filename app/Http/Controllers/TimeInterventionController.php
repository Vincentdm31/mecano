<?php

namespace App\Http\Controllers;


use App\Models\Intervention;
use App\Models\TimeIntervention;
use Carbon\Carbon;
use Illuminate\Http\Request;


class TimeInterventionController extends Controller
{
    public function store(Request $request)
    {
        $inputs = $request->except('_token');
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

        return redirect(route('interventions.edit', ['intervention' => $intervention]));
    }
}
