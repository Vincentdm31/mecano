<?php

namespace App\Http\Controllers;

use App\Models\Vehicule;
use Illuminate\Http\Request;

class VehiculeController extends Controller
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
        $intervention = $request->input('intervention_id');
        $inputs = $request->except('_token', 'created_at', 'updated_at');
        $vehicule = new Vehicule();
        foreach ($inputs as $key => $value) {
            $vehicule->$key = $value;
        }
        
        $vehicule->save();
        return redirect(route('interventions.edit', ['intervention' => $intervention, 'vehicule' => $vehicule]));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Vehicule  $vehicule
     * @return \Illuminate\Http\Response
     */
    public function show(Vehicule $vehicule)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Vehicule  $vehicule
     * @return \Illuminate\Http\Response
     */
    public function edit(Vehicule $vehicule)
    {
        //
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
        $intervention = $request->input('intervention_id');
        $inputs = $request->except('_token', '_method', 'updated_at');
        $vehicule = Vehicule::find($id);
        foreach ($inputs as $key => $value){
            $vehicule->$key = $value;
        }
        $vehicule->save();

       return redirect(route('interventions.edit', ['intervention' => $intervention, 'vehicule' => $vehicule]));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Vehicule  $vehicule
     * @return \Illuminate\Http\Response
     */
    public function destroy(Vehicule $vehicule)
    {
        //
    }
}
