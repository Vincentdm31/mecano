<?php

namespace App\Http\Controllers;

use App\Models\Piece;
use App\Models\PieceList;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

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
        $text = $request->ref;

        $pieceList = new PieceList();
        foreach ($inputs as $key => $value) {
            $pieceList->$key = $value;
        }

        $qrcode = QrCode::size(200)->generate($text);
        
        Storage::put('/public/images/'.'qr-'.$text.'.svg' , $qrcode);

        $pieceList->path = 'qr-' . $text . '.svg';
        $pieceList->save();

        return redirect(route('piecesList.show', ['piecesList' => $pieceList->id]));
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

    public function destroy($id)
    {
        $pieceList = PieceList::find($id);
        $pieceList->delete();

        return redirect(route('piecesList.index'))->with('toast', 'pieceListDelete');
    }

    // /**
    //  * Remove the specified resource from storage.
    //  *
    //  * @param  int $id
    //  * @return \Illuminate\Http\Response
    //  */
    // public function destroy($id)
    // {
    //     $pieceList = PieceList::find($id);
    //     $pieceList->delete();
        
    //     return redirect(route('piecesList.index'));
    // }

    // public function searchPiecesList(Request $request)
    // {
    //     $search = $request->get('searchPiecesList');

    //     $piecesList = PieceList::Where('name', 'like', '%'.$search.'%')
    //                 ->orWhere('ref', 'like', '%'.$search.'%')   
    //                 ->get();
    //     return view('pieces.index', ['piecesList' => $piecesList]);
    // }
    

    // /**
    //  * Store a newly created resource in storage.
    //  *
    //  * @param  \Illuminate\Http\Request  $request
    //  * @return \Illuminate\Http\Response
    //  */
    // public function store(Request $request)
    // {
    //     $inputs = $request->except('_token');

    //     if ($request->hasFile('img')) {
    //         $custom_file_name = $request->file('img')->getClientOriginalName();
    //         $path = $request->file('img')->storeAs('public/images', $custom_file_name);

    //         $piece = new Piece();
    //         foreach ($inputs as $key => $value) {
    //             $piece->$key = $value;
    //         }
    //         $piece->img = $custom_file_name;
    //         $piece->save();
    //     }

    //     return redirect(route('pieces.index'));
    // }

    // /**
    //  * Display the specified resource.
    //  *
    //  * @param  int $id
    //  * @return \Illuminate\Http\Response
    //  */
    // public function show($id)
    // {
    //     $piece = Piece::find($id);
    //     return view('pieces.show', ['piece' => $piece]);
    // }

    // /**
    //  * Show the form for editing the specified resource.
    //  *
    //  * @param  int $id
    //  * @return \Illuminate\Http\Response
    //  */
    // public function edit($id)
    // {   
    //     $piece = Piece::find($id);
    //     return view('pieces.edit', ['piece' => $piece]);
        
    // }

    // /**
    //  * Update the specified resource in storage.
    //  *
    //  * @param  \Illuminate\Http\Request  $request
    //  * @param  int $id
    //  * @return \Illuminate\Http\Response
    //  */
    // public function update(Request $request, $id)
    // {   
    //     $piece = Piece::find($id);
    //     $lastImg = $piece->img;
    //     Storage::disk('local')->delete('public/images/'.$lastImg);

    //     $inputs = $request->except('_token', '_method', 'updated_at');
    //     foreach ($inputs as $key => $value){
    //         $piece->$key = $value;
    //     }
    //     $piece->save();
        
    //     if ($request->hasFile('img')) {
    //         $custom_file_name = $request->file('img')->getClientOriginalName();
    //         $path = $request->file('img')->storeAs('public/images', $custom_file_name);

    //         $piece->img = $custom_file_name;
    //         $piece->save();
    //     }
        
    //    return redirect(route('pieces.index'));
    // }

    // /**
    //  * Remove the specified resource from storage.
    //  *
    //  * @param  int $id
    //  * @return \Illuminate\Http\Response
    //  */
    // public function destroy($id)
    // {
    //     $piece = Piece::find($id);
    //     $piece->delete();

    //     return redirect(route('pieces.index'));
    // }

    // public function searchPiece(Request $request)
    // {
    //     $search = $request->get('searchPiece');

    //     $pieces = Piece::Where('ref', 'like', '%'.$search.'%')
    //                 ->orWhere('name', 'like', '%'.$search.'%')
    //                 ->get();
    //     return view('pieces.index', ['pieces' => $pieces]);
    // }
}
