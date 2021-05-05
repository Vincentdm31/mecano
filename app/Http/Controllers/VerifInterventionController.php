<?php

namespace App\Http\Controllers;

use App\Models\Intervention;
use Illuminate\Http\Request;

class VerifInterventionController extends Controller
{   
    public function index()
    {
        $interventions = Intervention::where('state_verif', 'like', 'checking')
        ->orderBy('id', 'desc')
        ->paginate(5);

        return view('interventions.verifIntervention', ['interventions' => $interventions]);
    }

    public function verifFull()
    {
        $interventions = Intervention::where('state', '=', 'finish')
        ->orderBy('id', 'desc')
        ->paginate(5);

        return view('interventions.verifFull', ['interventions' => $interventions]);
    }

    public function validateVerif($id){
        $intervention = Intervention::find($id);

        $intervention->state_verif = 'checked';
        
        $intervention->save();

        return redirect(route('verif.index'));
    }

    public function searchInterventionVerif(Request $request)
    {
        $search = $request->get('searchInterventionVerif');

        $interventions = Intervention::whereHas('vehiculeList', function ($query) use($search) {
            $query->where('license_plate', 'like',  '%' . $search . '%');
       })->orderBy('id', 'desc')->paginate(5);

        return view('interventions.verifIntervention', ['interventions' => $interventions]);
    }

    public function searchInterventionFull(Request $request)
    {
        $search = $request->get('searchInterventionFull');

        $interventions = Intervention::whereHas('vehiculeList', function ($query) use($search) {
            $query->where('license_plate', 'like',  '%' . $search . '%');
       })->orderBy('id', 'desc')->paginate(5);

        return view('interventions.verifFull', ['interventions' => $interventions]);
    }
}
