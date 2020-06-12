<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

use App\Post;
use App\Comment;
use App\Friend;
use App\Image;


class User extends Authenticatable
{
    use Notifiable, HasApiTokens;


    protected $fillable = [
        'name', 'email', 'password',
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function getPathAttribute()
    {
        return "/users/$this->id";
    }

    public function posts()
    {
        return $this->hasMany(Post::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function friends()
    {
        return $this->belongsToMany(User::class, 'friends', 'friend_id', 'user_id');
    }

    public function likes()
    {
        return $this->belongsToMany(Post::class, 'likes', 'user_id', 'post_id');
    }

    public function images()
    {
        return $this->hasMany(Image::class);
    }

    public function coverImage()
    {
        return $this->hasOne(Image::class)
            ->orderByDesc('id')
            ->where('type', 'cover')
            ->withDefault(function ($image) {
                $image->path = 'uploadedImages/cover.jpg';
                $image->width = 1500;
                $image->height = 500;
                $image->type = 'cover';
            });
    }

    public function profileImage()
    {
        return $this->hasOne(Image::class)
            ->orderByDesc('id')
            ->where('type', 'profile')
            ->withDefault(function ($image) {
                $image->path = 'uploadedImages/profile.png';
                $image->width = 750;
                $image->height = 750;
                $image->type = 'profile';
            });
    }

    /*public function friends()
    {
        return $this->hasMany(Friend::class);
    }*/
}
