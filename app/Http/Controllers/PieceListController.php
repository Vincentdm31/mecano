<?php

namespace App\Http\Controllers;

use App\Models\Piece;
use App\Models\PieceList;
use Illuminate\Http\Request;

class PieceListController extends Controller
{
    public function index()
    {
        $piecesList = PieceList::all();
        return view('pieces.index', ['piecesList' => $piecesList]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('pieces.create');
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
        $piecesList = new PieceList();
        foreach ($inputs as $key => $value) {
            $piecesList->$key = $value;
        }

        $piecesList->save();
        return redirect(route('piecesList.index'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $pieceList = PieceList::find($id);
        return view('pieces.show', ['pieceList' => $pieceList]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {   
        $pieceList = PieceList::find($id);
        return view('pieces.edit', ['pieceList' => $pieceList ]);
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
        $pieceList = PieceList::find($id);
        foreach ($inputs as $key => $value){
            $pieceList->$key = $value;
        }
        $pieceList->save();

       return redirect(route('piecesList.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $pieceList = PieceList::find($id);
        $pieceList->delete();
        
        return redirect(route('piecesList.index'));
    }

    public function searchPiecesList(Request $request)
    {
        $search = $request->get('searchPiecesList');

        $piecesList = PieceList::Where('name', 'like', '%'.$search.'%')
                    ->orWhere('ref', 'like', '%'.$search.'%')   
                    ->get();
        return view('pieces.index', ['piecesList' => $piecesList]);
    }
}
