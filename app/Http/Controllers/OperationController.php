<?php

namespace App\Http\Controllers;

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
        $inputs = $request->except('_method', '_token');
        $intervention_id = $request->intervention_id;

        $operation = new Operation();

        foreach ($inputs as $key => $value) {
            $operation->$key = $value;
        }

        $operation->save();

        return redirect(route('interventions.edit', ['intervention' => $intervention_id]))->with('toast', 'addOperation');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Operation  $operation
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
    public function edit(Operation $operation)
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
        $inputs = $request->except('_token', '_method', 'updated_at');
        $intervention = $request->intervention_id;
        $operation = Operation::find($id);
        foreach ($inputs as $key => $value) {
            $operation->$key = $value;
        }
        $operation->save();

        return redirect(route('interventions.edit', ['intervention' => $intervention]))->with('toast', 'update');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Operation  $operation
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        $intervention = $request->intervention_id;

        $operation = Operation::find($id);
        $operation->delete();

        return redirect(route('interventions.edit', ['intervention' => $intervention]))->with('toast', 'removeOperation');
    }
}
