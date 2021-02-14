<?php

namespace App\Http\Controllers;

use App\Models\ImageUploader;
use Facade\FlareClient\Stacktrace\File;
use Illuminate\Contracts\Session\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ImageUploaderController extends Controller
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
        return view('images.create');
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
        $image = new ImageUploader();
        foreach ($inputs as $key => $value) {
            if ($request->hasFile('img') && $key == 'img') {
                if ($request->file('img')->isValid()) {
                    $image_name = $request->file('img')->getClientOriginalName();
                    $path = $request->file('img')->move(public_path() . '/images/', $image_name);
                    $image->$key = $image_name;
                }
            } else {
                $image->$key = $value;
            }
        }
        $image->save();
        return redirect('/adminGames');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ImageUploader  $imageUploader
     * @return \Illuminate\Http\Response
     */
    public function show(ImageUploader $imageUploader)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ImageUploader  $imageUploader
     * @return \Illuminate\Http\Response
     */
    public function edit(ImageUploader $imageUploader)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ImageUploader  $imageUploader
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ImageUploader $imageUploader)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ImageUploader  $imageUploader
     * @return \Illuminate\Http\Response
     */
    public function destroy(ImageUploader $imageUploader)
    {
        //
    }
}
