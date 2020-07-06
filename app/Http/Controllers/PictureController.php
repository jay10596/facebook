<?php

namespace App\Http\Controllers;

use App\Http\Resources\Picture as PictureResource;
use App\Http\Resources\Post as PostResource;
use App\Picture;
use App\Post;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;

class PictureController extends Controller
{
    public function uploadPicture()
    {
        $imageData = request()->validate([
            'image' => '',
        ]);

        $postData = request()->validate([
            'body' => '',
            'post_id' => ''
        ]);

        $post = null;
        $post = Post::find($postData['post_id']);

        //Create or Update the post body in the posts table of database.
        if($post != null) {
            $post->update(['body'=> $postData['body']]);
        } else {
            $post = request()->user()->posts()->create($postData);
        }

        //Create link to the storage and save the image there.
        $image = $imageData['image']->store('uploadedPostImages', 'public');

        //Crop image ni respect of requested height and width in case the size of image is bigger than requested width and height.
        Image::make($imageData['image'])
            ->save(storage_path('app/public/uploadedPostImages/' . $imageData['image']->hashName()));

        //Save the picture in the pictures table of database.
        Picture::create([
            'path' => $image,
            'type' => 'single',
            'post_id' => $post->id
        ]);

        return (new PostResource($post))->response()->setStatusCode(201);
    }
}
