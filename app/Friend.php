<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Friend extends Model
{
    protected $guarded = [];

    //To convert default String into a Carbon instance
    protected $dates =['confirmed_at'];

    public static function friendship($userId)
    {
        return (new static())
            ->where(function ($query) use ($userId) { return $query
            ->where('user_id', auth()->user()->id)
            ->where('friend_id', $userId);
        })  ->orWhere(function ($query) use ($userId) { return $query
            ->where('friend_id', auth()->user()->id)
            ->where('user_id', $userId);
        })->first();
    }

    public static function retrieveFriendships()
    {
        return (new static())
            ->whereNotNull('confirmed_at')
            ->where(function ($query) {
                return $query->where('user_id', auth()->user()->id)
                    ->orWhere('user_id', auth()->user()->id);
            })->get();
    }
}
