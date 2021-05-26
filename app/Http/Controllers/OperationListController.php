<?php

namespace App\Http\Controllers;

use App\Models\OperationList;
use Illuminate\Http\Request;

class OperationListController extends Controller
{
    public function index()
    {
        $operationsLists = OperationList::orderBy('name')->paginate(5);

        return view('operations.index', ['operationsLists' => $operationsLists]);
    }

    public function create()
    {
        return view('operations.create');
    }

    public function store(Request $request)
    {
        $inputs = $request->except('_token', 'created_at', 'updated_at', 'isPackage');
        $isPackage = $request->isPackage;
        $operationList = new OperationList();

        foreach ($inputs as $key => $value) {
            $operationList->$key = $value;
        }
        if($isPackage != null){
            $operationList->isPackage = true;
        }
        $operationList->save();

        return redirect(route('operationsList.index'));
    }

    public function edit($id)
    {
        $operationList = OperationList::find($id);

        return view('operations.edit', ['operationList' => $operationList]);
    }

    public function update(Request $request, $id)
    {
        $inputs = $request->except('_token', '_method', 'updated_at', 'isPackage');
        $operationList = OperationList::find($id);

        $isPackage = $request->isPackage;


        foreach ($inputs as $key => $value) {
            $operationList->$key = $value;
        }

        if($isPackage != null){
            $operationList->isPackage = true;
        }else{
            $operationList->isPackage = false;
        }

        $operationList->save();

        return redirect(route('operationsList.index'));
    }

    public function destroy($id)
    {
        $operationList = OperationList::find($id);
        $operationList->delete();

        return redirect(route('operationsList.index'));
    }
}
