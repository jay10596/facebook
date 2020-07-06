<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


//AUTH
Route::post('/login', 'AuthController@login');
Route::post('/register', 'AuthController@register');
Route::post('/me', 'AuthController@me');
Route::post('/logout', 'AuthController@logout');
//auth middleware in Constructor of AuthController is added. If not, I need to put me and logout routes inside the Route::middleware('auth:api') group

Route::middleware('auth:api')->group(function () {
    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    //CRUD
    Route::apiResource('/posts', 'PostController');
    Route::apiResource('/users', 'UserController');
    Route::apiResource('/posts/{post}/comments', 'CommentController');

    //FRIEND REQUEST
    Route::post('/send-request', 'FriendController@sendRequest');
    Route::post('/confirm-request', 'FriendController@confirmRequest');
    Route::post('/delete-request', 'FriendController@deleteRequest');

    //LIKE
    Route::post('/posts/{post}/like-dislike', 'LikeController@likeDislike');

    //IMAGE
    Route::post('/upload-images', 'ImageController@uploadImage');
    Route::post('/upload-pictures', 'PictureController@uploadPicture');
});
