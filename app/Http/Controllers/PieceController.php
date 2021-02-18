<?php

namespace App\Http\Controllers;

use App\Models\Piece;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PieceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $pieces = Piece::all();
        return view('pieces.index', ['pieces' => $pieces]);
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
        $inputs = $request->except('_token');

        if ($request->hasFile('img')) {
            $custom_file_name = $request->file('img')->getClientOriginalName();
            $path = $request->file('img')->storeAs('public/images', $custom_file_name);

            $piece = new Piece();
            foreach ($inputs as $key => $value) {
                $piece->$key = $value;
            }
            $piece->img = $custom_file_name;
            $piece->save();
        }

        return redirect(route('pieces.index'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $piece = Piece::find($id);
        return view('pieces.show', ['piece' => $piece]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {   
        $piece = Piece::find($id);
        return view('pieces.edit', ['piece' => $piece]);
        
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
        $piece = Piece::find($id);
        $lastImg = $piece->img;
        Storage::disk('local')->delete('public/images/'.$lastImg);

        $inputs = $request->except('_token', '_method', 'updated_at');
        foreach ($inputs as $key => $value){
            $piece->$key = $value;
        }
        $piece->save();
        
        if ($request->hasFile('img')) {
            $custom_file_name = $request->file('img')->getClientOriginalName();
            $path = $request->file('img')->storeAs('public/images', $custom_file_name);

            $piece->img = $custom_file_name;
            $piece->save();
        }
        
       return redirect(route('pieces.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $piece = Piece::find($id);
        $piece->delete();

        return redirect(route('pieces.index'));
    }

    public function searchPiece(Request $request)
    {
        $search = $request->get('searchPiece');

        $pieces = Piece::Where('ref', 'like', '%'.$search.'%')
                    ->orWhere('name', 'like', '%'.$search.'%')
                    ->get();
        return view('pieces.index', ['pieces' => $pieces]);
    }
}
