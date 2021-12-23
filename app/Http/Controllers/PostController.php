<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\StorePostRequest;
use App\Models\Post;
use App\Models\Image;
use Illuminate\Support\Facades\Storage; 


class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $userId = auth()->user()->id;
     
        $posts = Post::where('user_id','=',$userId)->with(['user'])->paginate(5);
        
        return view('posts.index',compact('posts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('posts.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorePostRequest $request)
    {
        
        $post = new Post;

        $post->title = $request->title;
        $post->description = $request->description;
        $post->user_id = auth()->user()->id;
        $post->save();
        
        if($request->hasFile('image')){
            
            foreach($request->file('image') as $file)
            {
                $path = $file->store('public/images/posts');
                Image::create(['post_id'=>$post->id,'path'=>$path]);
            }

        }

        
     
        return redirect()->route('posts.index')
                          ->with('success','Post has been created successfully.');
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
    public function edit(Post $post)
    {
        return view('posts.edit',compact('post'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(StorePostRequest $request, $id)
    {
        $post = Post::find($id);

        $post->title = $request->title;
        $post->description = $request->description;
        $post->user_id = auth()->user()->id;
        
        $post->save();

        if($request->hasFile('image')){

            // remove old images 
            if($post->images){
                foreach($post->images as $image){
                    unlink('.'.Storage::url($image->path));
                    $image->delete();
                }
            }
            
            //add the new ones
            foreach($request->file('image') as $file)
            {
                $path = $file->store('public/images/posts');
                Image::create(['post_id'=>$post->id,'path'=>$path]);
            }

        }

    
        return redirect()->route('posts.index')
                        ->with('success','Post updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {

        if($post->images){
            foreach($post->images as $image){
                unlink('.'.Storage::url($image->path));
            }
        }

        $post->delete();
    
        return redirect()->route('posts.index')
                         ->with('success','Post has been deleted successfully');
    }
}
