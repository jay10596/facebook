<?php

use Illuminate\Database\Seeder;

use App\User;
use App\Post;
use App\Comment;
use App\Like;


class DatabaseSeeder extends Seeder
{
    public function run()
    {
        factory(User::class, 5)->create();
        factory(Post::class, 10)->create();
        factory(Like::class, 5)->create();
        factory(Comment::class, 10)->create();
    }
}
