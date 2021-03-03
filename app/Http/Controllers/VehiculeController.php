<?php

namespace App\Http\Controllers;

use App\Models\Vehicule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class VehiculeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {   
        $vehicules = Vehicule::all();
        return view('vehicules.index', ['vehicules' => $vehicules]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('vehicules.create');
        
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
        $vehicule = new Vehicule();
        foreach ($inputs as $key => $value) {
            $vehicule->$key = $value;
        }
        
        $vehicule->save();
        return redirect(route('vehicules.index'));
        
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
    public function edit($id)
    {   
        $vehicule = Vehicule::find($id);
        return view('vehicules.edit', ['vehicule' => $vehicule ]);
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
        $vehicule = Vehicule::find($id);
        foreach ($inputs as $key => $value){
            $vehicule->$key = $value;
        }
        $vehicule->save();

       return redirect(route('vehicules.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $vehicule = Vehicule::find($id);
        $vehicule->delete();
        
        
        return redirect(route('vehicules.index'));
    }

    public function searchVehicule(Request $request)
    {
        $search = $request->get('searchVehicule');

        $vehicules = Vehicule::Where('marque', 'like', '%'.$search.'%')
                    ->orWhere('modele', 'like', '%'.$search.'%')
                    ->orWhere('immat', 'like', '%'.$search.'%')
                    ->get();
        return view('vehicules.index', ['vehicules' => $vehicules]);
    }

    public function getVehicules()
    {

        $response = Http::get('https://my-json-server.typicode.com/typicode/demo/posts');


        foreach (json_decode($response->getBody()) as $item) {

            $vehicule = new Vehicule();
            $vehicule->marque = $item->title;
            $vehicule->modele = "test";
            $vehicule->immat = "testt";
            $vehicule->save();
            // TEST API
        }

        return redirect(route('vehicules.index'))->with('toast', 'vehiculeUpdate');
    }
}
