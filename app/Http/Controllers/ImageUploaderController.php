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
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:1024',
        ]);
    
        $imageName = time().'.'.$request->image->extension();
     
        $request->image->move(public_path('images'), $imageName);
  
    
        return redirect()->back()->with('success','Image uploaded successfully.')->with('image',$imageName);
    
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
