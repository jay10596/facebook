<?php

namespace App\Http\Controllers;

use App\Http\Resources\LikeCollection;
use Illuminate\Http\Request;

use App\Post;


class LikeController extends Controller
{
    public function likeDislike(Post $post)
    {
        $post->likes()->toggle(auth()->user());

        return new LikeCollection($post->likes);
    }
}
