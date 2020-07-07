<?php

namespace Tests\Feature;

use App\Friend;
use App\Image;
use App\Picture;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use App\Http\Resources\UserResource;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;
use Illuminate\Support\Facades\Artisan;

use App\User;
use App\Post;
use Carbon\Carbon;


class PostTest extends TestCase
{
    use RefreshDatabase;

    protected $user;
    protected $token;
    protected $server;

    protected $post;

    protected function setUp(): void
    {
        parent::setUp();

        Artisan::call('passport:install',['-vvv' => true]);

        $this->user = factory(User::class)->create();

        $this->token = $this->user->createToken('MyApp')->accessToken;

        $this->server = [
            'HTTP_Authorization' => 'Bearer '. $this->token
        ];

        Storage::fake('public');
    }

    private function data()
    {
        return [
            'body' => 'This is a new post.',
        ];
    }

    /** @test */
    //actingAs is another way to login if you don't want pass the token
    public function auth_user_can_fetch_all_posts_of_his_friends()
    {
        $this->actingAs($user1 = factory(User::class)->create(), 'api'); //It just logs in the user

        $user2 = factory(User::class)->create();

        $posts = factory(Post::class, 2)->create(['user_id' => $user2->id]);

        Friend::create([
            'user_id' => $user1->id,
            'friend_id' => $user2->id,
            'confirmed_at' => now(),
            'status' => 1
        ]);

        $response = $this->get('/api/posts');

        $response->assertJson([
            'data' => [
                [
                    'id' => $posts->first()->id,
                    'body' => $posts->first()->body,
                    'user_id' => $posts->first()->user_id,
                    'created_at' => $posts->first()->created_at->diffForHumans(),

                    'posted_by' => [
                        'id' => $user2->id,
                        'name' => $user2->name,
                        'email' => $user2->email,
                    ],

                    'path' => $posts->first()->path
                ],
                [
                    'id' => $posts->last()->id,
                    'body' => $posts->last()->body,
                    'user_id' => $posts->last()->user_id,
                    'created_at' => $posts->last()->created_at->diffForHumans(),

                    'posted_by' => [
                        'id' => $user2->id,
                        'name' => $user2->name,
                        'email' => $user2->email,
                    ],

                    'path' => $posts->last()->path
                ]
            ],
            'links' => [
                'self' => '/posts'
            ]
        ]);
    }

    /** @test */
    public function auth_user_cannot_fetch_others_posts()
    {
        $this->actingAs($user = factory(User::class)->create(), 'api');

        $user2 = factory(User::class)->create();

        $posts = factory(Post::class, 2)->create(['user_id' => $user2->id]); //These posts do not belong to logged in user

        $response = $this->get('/api/posts');

        $response->assertExactJson([
            'data' => [],
            'links' => [
                'self' => '/posts'
            ]
        ]);
    }

    /** @test */
    public function auth_user_can_create_text_post()
    {   //One way to create a post
        $post = factory(Post::class)->create(['user_id' => $this->user->id]);

        //Second way to create a post
        $response = $this->post('/api/posts', $this->data(), $this->server);

        $response->assertStatus(201);

        $this->assertCount(2, Post::all());

        $posts = Post::all();
        $post = $posts->last();

        $this->assertEquals('This is a new post.', $post->body);
        $this->assertEquals($post->user_id, $this->user->id);

        $response->assertJson([
            'data' => [
                'id' => $post->id,
                'body' => $post->body,
                'user_id' => $post->user_id,
                'created_at' => $post->created_at->diffForHumans(),

                'posted_by' => [
                    'id' => $this->user->id,
                    'name' => $this->user->name,
                    'email' => $this->user->email,
                ],

                'path' => $post->path
            ]
        ]);
    }

    /** @test */
    public function auth_user_can_create_single_picture_post()
    {
        $this->actingAs($user = factory(User::class)->create(), 'api'); //It just logs in the user

        $file = UploadedFile::fake()->image('postImage.jpg');

        $response = $this->post('/api/upload-pictures', [
            'body' => 'test Body',
            'image' => [$file],
            'post_id' => '',
            'user_id' => $user->id
        ])->assertStatus(201);

        Storage::disk('public')->assertExists('uploadedPostImages/' . $file->hashName());

        $this->assertCount(1, Post::all());
        $this->assertCount(1, Picture::all());

        $post = Post::first();
        $picture = Picture::first();

        $response->assertJson([
            'data' => [
                'id' => $post->id,
                'body' => $post->body,
                'user_id' => $post->user_id,
                'created_at' => $post->created_at->diffForHumans(),

                'comments' => [

                ],

                'likes' => [

                ],

                'single_picture' => [
                    'id' => $picture->id,
                    'path' => $picture->path,
                    'type' => $picture->type,
                ],

                'multiple_pictures' => [

                ],

                'posted_by' => [
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                ],

                'path' => $post->path
            ]
        ]);
    }

    /** @test */
    public function auth_user_can_create_multiple_pictures_post()
    {
        $this->withoutExceptionHandling();

        $this->actingAs($user = factory(User::class)->create(), 'api'); //It just logs in the user

        $file1 = UploadedFile::fake()->image('postImage1.jpg');
        $file2 = UploadedFile::fake()->image('postImage2.jpg');
        $file3 = UploadedFile::fake()->image('postImage3.jpg');

        $response = $this->post('/api/upload-pictures', [
            'body' => 'test Body',
            'image' => [$file1, $file2, $file3],
            'post_id' => '',
            'user_id' => $user->id
        ])->assertStatus(201);

        Storage::disk('public')->assertExists('uploadedPostImages/' . $file1->hashName());
        Storage::disk('public')->assertExists('uploadedPostImages/' . $file2->hashName());
        Storage::disk('public')->assertExists('uploadedPostImages/' . $file3->hashName());

        $this->assertCount(1, Post::all());
        $this->assertCount(3, Picture::all());

        $post = Post::first();
        $pictures = Picture::all();
        $picture1 = $pictures[0];
        $picture2 = $pictures[1];
        $picture3 = $pictures[2];

        $response->assertJson([
            'data' => [
                'id' => $post->id,
                'body' => $post->body,
                'user_id' => $post->user_id,
                'created_at' => $post->created_at->diffForHumans(),

                'comments' => [

                ],

                'likes' => [

                ],

                'single_picture' => [

                ],

                'multiple_pictures' => [
                    'data' => [
                        [
                            'id' => $picture1->id,
                            'path' => $picture1->path,
                            'type' => $picture1->type,
                        ],
                        [
                            'id' => $picture2->id,
                            'path' => $picture2->path,
                            'type' => $picture2->type,
                        ],
                        [
                            'id' => $picture3->id,
                            'path' => $picture3->path,
                            'type' => $picture3->type,
                        ],
                    ],
                    'links' => [
                        'self' => '/posts'
                    ],
                    'picture_count' => 3
                ],

                'posted_by' => [
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                ],

                'path' => $post->path
            ]
        ]);
    }

    /** @test */
    public function auth_user_can_update_text_post()
    {
        $this->actingAs($user = factory(User::class)->create(), 'api'); //It just logs in the user

        $post = factory(Post::class)->create(['user_id' => $user->id]);

        $response = $this->put('/api/posts/' . $post->id, ['body' => 'An updated post']);

        $response->assertStatus(201);

        $post = Post::first();

        $this->assertEquals('An updated post', $post->body);

        $response->assertJson([
            'data' => [
                'id' => $post->id,
                'body' => 'An updated post',
                'user_id' => $post->user_id,
                'created_at' => $post->created_at->diffForHumans(),

                'posted_by' => [
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                ],

                'path' => $post->path
            ]
        ]);
    }

    /** @test */
    public function auth_user_can_update_picture_post()
    {
        $this->actingAs($user = factory(User::class)->create(), 'api'); //It just logs in the user

        $file = UploadedFile::fake()->image('postImage.jpg');

        $post = factory(Post::class)->create(['user_id' => $user->id]);

        $response = $this->post('/api/upload-pictures', [
            'body' => 'test Body',
            'image' => [$file],
            'post_id' => $post->id,
            'user_id' => $user->id
        ])->assertStatus(201);

        Storage::disk('public')->assertExists('uploadedPostImages/' . $file->hashName());

        $this->assertCount(1, Post::all());
        $this->assertCount(1, Picture::all());

        $post = Post::first();
        $picture = Picture::first();

        $response->assertJson([
            'data' => [
                'id' => $post->id,
                'body' => 'test Body',
                'user_id' => $post->user_id,
                'created_at' => $post->created_at->diffForHumans(),

                'comments' => [

                ],

                'likes' => [

                ],

                'single_picture' => [
                    'id' => $picture->id,
                    'path' => $picture->path,
                    'type' => $picture->type,
                ],

                'multiple_pictures' => [

                ],

                'posted_by' => [
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                ],

                'path' => $post->path
            ]
        ]);
    }

    /** @test */
    public function auth_user_can_delete_posts()
    {
        $this->actingAs($user = factory(User::class)->create(), 'api'); //It just logs in the user

        $post = factory(Post::class)->create(['user_id' => $user->id]);

        $response = $this->delete('/api/posts/' . $post->id);

        $response->assertStatus(204);

        $posts = Post::all();

        $this->assertCount(0, $posts);
    }
}
