<?php

namespace App\Http\Controllers;

use App\Http\Resources\Image as ImageResource;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;

class ImageController extends Controller
{
    public function uploadImage()
    {
        $data = request()->validate([
            'image' => '',
            'width' => '',
            'height' => '',
            'type' => '',
        ]);

        //Create link to the storage and save the image there.
        $image = $data['image']->store('uploadedImages', 'public');

        //Crop image ni respect of requested height and width in case the size of image is bigger than requested width and height.
        Image::make($data['image'])
            ->fit($data['width'], $data['height'])
            ->save(storage_path('app/public/uploadedImages/' . $data['image']->hashName()));

        //Save the image in the database.
        $userImage = auth()->user()->images()->create([
            'path' => $image,
            'width' => $data['width'],
            'height' => $data['height'],
            'type' => $data['type']
        ]);

        return new ImageResource($userImage);
    }
}
