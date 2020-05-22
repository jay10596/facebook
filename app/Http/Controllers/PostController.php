<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Resources\PostResource;
use App\Http\Resources\PostCollection;
use App\Http\Requests\PostRequest;


use Auth;
use App\Post;


class PostController extends Controller
{
    public function index()
    {
        return PostResource::collection(Auth::user()->posts()->latest()->get());
    }

    public function create()
    {
        //
    }

    public function store(PostRequest $request)
    {         
        $post = Auth::user()->posts()->create($request->all()); 

        /*  //Another way to validate if PostRequest is not made
            $data = request()->validate([
                'body' => 'required'
            ]);

            $post = Auth::user()->posts()->create($data); 

            
            //Another way to create post
            $post = Post::create([
                'body' => $request->body,
                'user_id' => Auth::user()->id
            ]);
        */

        return (new PostResource($post))->response()->setStatusCode(201);
    }

    public function show(Post $post)
    {
        //
    }

    public function edit(Post $post)
    {
        //
    }

    public function update(Request $request, Post $post)
    {
        //
    }

    public function destroy(Post $post)
    {
        //
    }
}
