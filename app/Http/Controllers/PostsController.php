<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\Posts\CreatePostRequest;
use App\Post;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\Posts\updatePostRequest;


class PostsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('posts.index')->with('posts',Post::all());
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
    public function store(CreatePostRequest $request)
    {
        $image = $request->image->store('post');

        Post::create([
            'title'         => $request->title,
            'description'   => $request->description,
            'content'       => $request->content,
            'image'         => $image,
            'published_at'  => $request->published_at
        ]);

        session()->flash('success', 'Post Created Successfully');

        return redirect(route('posts.index'));
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
        return view('posts.create')->with('post',$post);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(updatePostRequest $request,Post $post)
    {
        $data = $request->only(['title','description','content','published_at']);
        //if new image
        if($request->hasFile('image'))
        {
            //upload it
            $image = $request->image->store('post');
            //delete previous one
            $post->deleteImages();
            //Storage::delete($post->image);

            $data['image'] = $image;
        }

        //update attribute
        $post->update($data);

        //flash message
        session()->flash('success', 'Post Updated Successfully');

        //redirect

        return redirect(route('posts.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $post = Post::withTrashed()->where('id',$id)->firstOrFail();

        if($post->trashed())
        {
            $post->deleteImages();
            //Storage::delete($post->image);
            $post->forceDelete();
            session()->flash('success', 'Post Deleted Successfully');
        }
        else{
            $post->delete();
            session()->flash('success', 'Post Trashed Successfully');
        }


        return redirect(route('posts.index'));
    }

     /**
     * Show trashed Posts.
     *
     * @return \Illuminate\Http\Response
     */

     public function trashed()
     {
        $trashed = Post::onlyTrashed()->get();
        return view('posts.index')->with('posts',$trashed);
     }

     public function restore($id)
     {
        $post = Post::withTrashed()->where('id',$id)->firstOrFail();
        $post->restore();
        session()->flash('success', 'Post Restored Successfully');
        return redirect()->back();
     }
}
