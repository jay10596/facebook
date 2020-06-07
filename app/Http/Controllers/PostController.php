<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Resources\Post as PostResource;
use App\Http\Resources\PostCollection;
use App\Http\Requests\PostRequest;

use Auth;
use App\Post;
use App\Friend;


class PostController extends Controller
{
    public function index()
    {
        $friends = Friend::retrieveFriendships();

        if ($friends->isEmpty()) {
            return new PostCollection(Auth::user()->posts()->latest()->get());
        }

        return new PostCollection(Post::whereIn('user_id', [$friends->pluck('user_id'), $friends->pluck('friend_id')])->get());


        /*  //Without PostCollection
            return PostResource::collection(Auth::user()->posts()->latest()->get());
        */
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
