<?php

namespace App\Http\Controllers;

use App\Models\Categorie;
use App\Models\Intervention;
use App\Models\Operation;
use Illuminate\Http\Request;

class OperationController extends Controller
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
        $operation = new Operation();
        foreach ($inputs as $key => $value) {
            $operation->$key = $value;
        }
        $categorieName = $request->input('name');
        $categorieId = Categorie::Where('name', 'like', '%'.$categorieName.'%')->pluck('id')->implode(' ');
        $operation->categorie_id = $categorieId;
        $operation->save();
        return redirect(route('interventions.edit', ['intervention' => $intervention, 'operation' => $operation]));
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show(Operation $operation)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Operation  $operation
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $id)
    {
        
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
        $inputs = $request->except('_token', '_method', 'created_at', 'updated_at');
        $intervention =  $request->input('intervention_id');
        $intervention = Intervention::find($intervention);
        $operation =  Operation::find($id);        
        $categories = Categorie::all();

        foreach ($inputs as $key => $value) {
            $operation->$key = $value;
        }
        $operation->save();

        return redirect( route('interventions.edit', ['intervention' => $intervention, 'operation' => $operation, 'categories' => $categories]));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Operation  $operation
     * @return \Illuminate\Http\Response
     */
    public function destroy(Operation $operation)
    {
        //
    }
}
