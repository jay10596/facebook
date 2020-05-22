<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Scopes\ReverseScope;

use App\User;

class Post extends Model
{
    protected $fillable = ['body', 'user_id'];


    public function getPathAttribute()
    {
        return "/posts/$this->id";
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
