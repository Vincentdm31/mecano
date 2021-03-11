<?php

namespace App\Http\Controllers;

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

        Storage::put('/public/images/' . 'qr-' . $text . '.svg', $qrcode);

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
        return view('pieces.edit', ['pieceList' => $pieceList]);
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
        foreach ($inputs as $key => $value) {
            $pieceList->$key = $value;
        }
        $pieceList->save();

        return redirect(route('piecesList.index'));
    }

    public function destroy($id)
    {
        $pieceList = PieceList::find($id);
        $path = $pieceList->path;

        Storage::delete('/public/images/' . $path);
        $pieceList->delete();

        return redirect(route('piecesList.index'))->with('toast', 'pieceListDelete');
    }
}
