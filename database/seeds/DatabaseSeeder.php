<?php

use Illuminate\Database\Seeder;
use App\Post;
use App\User;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        factory(User::class, 3)->create();
        factory(Post::class, 10)->create();
    }
}
