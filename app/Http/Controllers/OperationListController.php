<?php

namespace App\Http\Controllers;

use App\Models\OperationList;
use Illuminate\Http\Request;

class OperationListController extends Controller
{
    public function index()
    {
        $operationsLists = OperationList::orderBy('name')->paginate(12);

        return view('operations.index', ['operationsLists' => $operationsLists]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('operations.create');
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
        $operationList = new OperationList();

        foreach ($inputs as $key => $value) {
            $operationList->$key = $value;
        }

        $operationList->save();

        return redirect(route('operationsList.index'));
    }

    public function edit($id)
    {
        $operationList = OperationList::find($id);

        return view('operations.edit', ['operationList' => $operationList]);
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
        $operationList = OperationList::find($id);

        foreach ($inputs as $key => $value) {
            $operationList->$key = $value;
        }

        $operationList->save();

        return redirect(route('operationsList.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $operationList = OperationList::find($id);
        $operationList->delete();

        return redirect(route('operationsList.index'));
    }

    public function searchOperationsList(Request $request)
    {
        $search = $request->get('searchOperationsList');

        $operationsLists = OperationList::Where('name', 'like', '%' . $search . '%')->orderBy('name')->paginate(8);



        return view('operations.index', ['operationsLists' => $operationsLists]);
    }
}
