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
        return view('upload.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if ($request->hasFile('img')) {
            $custom_file_name = $request->file('img')->getClientOriginalName();
            $path = $request->file('img')->storeAs('public/images', $custom_file_name);

            $img = new ImageUploader();
            $img->image = $custom_file_name;
            $img->save();
        }


        return redirect('/');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ImageUploader  $imageUploader
     * @return \Illuminate\Http\Response
     */

    public function show($id)
    {
        $image = ImageUploader::find($id);
        return view('upload.show', ['image' => $image]);
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
