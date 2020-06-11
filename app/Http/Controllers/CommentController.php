<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Resources\Comment as CommentResource;
use App\Http\Resources\CommentCollection;

use App\Comment;
use App\Post;


class CommentController extends Controller
{
    public function index()
    {
        //
    }

    public function store(Post $post)
    {
        /*
            public function store(Post $post, CommentRequest $request)
            {
                $request['user_id'] = auth()->user()->id;

		        $comment = $post->comments()->create($request->all());
            }
        */
        $data = request()->validate([
            'body' => 'required',
        ]);

        /*
            $comment = $post->comments()->create(array_merge($data, ['user_id' => auth()->user()->id]));

            return new CommentResource($comment);
        */
        $post->comments()->create(array_merge($data, ['user_id' => auth()->user()->id]));

        return new CommentCollection($post->comments);
    }

    public function show(Comment $comment)
    {
        //
    }

    public function update(Request $request, Comment $comment)
    {
        //
    }

    public function destroy(Comment $comment)
    {
        //
    }
}
