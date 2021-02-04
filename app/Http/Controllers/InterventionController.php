<?php

namespace App\Http\Controllers;

use App\Models\Categorie;
use App\Models\Intervention;
use App\Models\Vehicule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class InterventionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {   
        $interventions = Intervention::all();

        return view('interventions.index', ['interventions' => $interventions]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('interventions.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {   

        $inputs = $request->except('_token', 'created_at', 'updated_at');
        $intervention = new Intervention();
        foreach ($inputs as $key => $value) {
            $intervention->$key = $value;
        }
        $intervention->state = "doing";

        $intervention->save();
        $intervention->users()->attach(Auth()->user()->id);
        return redirect(route('interventions.edit', ['intervention' => $intervention]));
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show(Intervention $intervention)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Intervention  $intervention
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $id)
    {   
        $intervention =  Intervention::find($id);
        //$vehicules = Vehicule::all();
        $search = $request->get('selectVehicule');
        $vehicules = Vehicule::Where('immat', 'like', '%'.$search.'%')
                    ->get();
        
        $categories = Categorie::all();

        return view('interventions.edit', ['intervention' => $intervention, 'vehicules' => $vehicules, 'categories' => $categories]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {   
        $inputs = $request->except('_token', '_method', 'updated_at');
        $intervention = Intervention::find($id);
        foreach ($inputs as $key => $value){
            $intervention->$key = $value;
        }

        $intervention->save();

       return redirect(route('interventions.edit', ['intervention' => $intervention]));
    }

    

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Intervention  $intervention
     * @return \Illuminate\Http\Response
     */
    public function destroy(Intervention $intervention)
    {
        //
    }

    public function selectVehicule(Request $request)
    {   
        $interventionID = $request->get('intervention_id');
        $intervention = Intervention::find($interventionID);

        $search = $request->get('selectVehicule');

        $vehicules = Vehicule::Where('immat', 'like', '%'.$search.'%')
                    ->orWhere('marque', 'like', '%'.$search.'%')
                    ->get();
        return view('interventions.edit', ['intervention' => $intervention, 'vehicules' => $vehicules]);
    }


}
