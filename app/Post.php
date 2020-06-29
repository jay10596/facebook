<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Scopes\ReverseScope;

use App\User;
use App\Comment;


class Post extends Model
{
    protected $fillable = ['body', 'image', 'user_id'];

    public function getPathAttribute()
    {
        return "/posts/$this->id";
    }

    public function comments()
    {
        return $this->hasMany(Comment::class)->latest('updated_at');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function likes()
    {
        return $this->belongsToMany(User::class, 'likes', 'post_id', 'user_id');
    }
}
