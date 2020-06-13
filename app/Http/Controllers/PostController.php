<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Resources\Post as PostResource;
use App\Http\Resources\PostCollection;
use App\Http\Requests\PostRequest;

use Auth;
use App\Post;
use App\Friend;
use Intervention\Image\Facades\Image;


class PostController extends Controller
{
    public function index()
    {
        $friends = Friend::retrieveFriendships();

        if ($friends->isEmpty()) {
            return new PostCollection(Auth::user()->posts()->latest()->get());
        }

        return new PostCollection(Post::whereIn('user_id', [$friends->pluck('user_id'), $friends->pluck('friend_id')])->latest()->get());


        /*  //Without PostCollection
            return PostResource::collection(Auth::user()->posts()->latest()->get());
        */
    }

    public function store()
    {
        /*  Different ways!

			$request['slug'] = Str::slug($request->title);

			$data = request()->validate([
			    'body' => 'required'
			]);
				#OR

			store(PostRequest $request)// Set new request rules

			$post = Auth::user()->posts()->create($request->all());
				#OR
			$post = Auth::user()->posts()->create($data);
				#OR
			$post = Post::create([
				'body' => $request->body,
				'user_id' => Auth::user()->id
			]);
		*/

        $data = request()->validate([
            'body' => '',
            'image' => '',
            'width' => '',
            'height' => ''
        ]);

        if (isset($data['image'])) {
            //Store image in the storage
            $image = $data['image']->store('uploadedPostImages', 'public');

            //Resize image
            Image::make($data['image'])
                ->fit($data['width'], $data['height'])
                ->save(storage_path('app/public/uploadedPostImages/' . $data['image']->hashName()));
        }

        //Store body and image in the database
        $post = request()->user()->posts()->create([
            'body' => $data['body'],
            'image' => $image ?? null,
        ]);

        return (new PostResource($post))->response()->setStatusCode(201);
    }

    public function show(Post $post)
    {
        return new PostResource($post);
    }

    public function update(PostRequest $request, Post $post)
    {
        $post->update($request->all());

        return (new PostResource($post))->response()->setStatusCode(201);
    }

    public function destroy(Post $post)
    {
        $post->delete();

        return response('Deleted', 204);
    }
}
