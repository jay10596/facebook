<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Resources\Comment as CommentResource;
use App\Http\Resources\CommentCollection;
use App\Http\Resources\Post as PostResource;

use App\Comment;
use App\Post;


class CommentController extends Controller
{
    public function index(Post $post)
    {
        return new PostResource($post);
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

    public function update(Request $request, Post $post, Comment $comment)
    {
        $comment->update($request->all());

        return new CommentCollection($post->comments);
    }

    public function destroy(Post $post, Comment $comment)
    {
        $comment->delete();

        return response('Deleted', 204);
    }
}
