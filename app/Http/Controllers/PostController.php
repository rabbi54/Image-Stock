<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Post;
use App\Models\Image;

class PostController extends Controller
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
        return view('upload');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        
        $validatedData = $request->validate(
            [
            'images' => 'required',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'title' => 'required'
            ]
        );

        if( $request->hasFile('images')){
            $files =  $request->file('images');

            $post = new Post([
                'title' => $request->input('title'),
            ]);

            // saving the post but not the images yet
            auth()->user()->posts()->save($post);

            // $count = 0;
            foreach($files as $file){
                $timestamp = rand(10990, 1029901);
                $fileName = $timestamp . $file->getClientOriginalName();
                $file->move(public_path('post-images'), $fileName);

                $image = new Image([
                    "name" => $fileName
                ]);

                if($post->images()->save($image)){
                    // count++;
                    // return redirect()->route('home')->with('success', "Image uploaded successfully.");
                }
                else{
                    return back()->withInput('msg', "There is a problem!");
                }

            }
            return redirect()->route('home')->with('success', "Image uploaded successfully.");
        }else{
            return back()->withInput('msg', "Please choose any image File");
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
