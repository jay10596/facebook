<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\UploadedFile;
use Tests\TestCase;

use App\Post;
use App\User;
use App\Image;


class ImageTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        Storage::fake('public');
    }

    /** @test */
    public function auth_user_can_upload_image()
    {
        $this->actingAs($user = factory(User::class)->create(), 'api'); //It just logs in the user

        $file = UploadedFile::fake()->image('image.jpg');

        $response = $this->post('/api/upload-images', [
            'image' => $file,
            'width' => '850',
            'height' => '300',
            'type' => 'cover'
        ])->assertStatus(201);

        Storage::disk('public')->assertExists('uploadedImages/' . $file->hashName());

        $image = Image::first();

        $this->assertEquals('uploadedImages/' . $file->hashName(), $image->path);
        $this->assertEquals('850', $image->width);
        $this->assertEquals('300', $image->height);
        $this->assertEquals('cover', $image->type);

        $response->assertJson([
            'data' => [
                'id' => $image->id,
                'path' => $image->path,
                'width' => $image->width,
                'height' => $image->height,
                'type' => $image->type,
            ]
        ]);
    }

    /** @test */
    public function users_are_fetched_with_their_images()
    {
        $this->withoutExceptionHandling();

        $this->actingAs($user = factory(User::class)->create(), 'api'); //It just logs in the user

        $file = UploadedFile::fake()->image('image.jpg');

        $this->post('/api/upload-images', [
            'image' => $file,
            'width' => 850,
            'height' => 300,
            'type' => 'cover'
        ])->assertStatus(201);

        $this->post('/api/upload-images', [
            'image' => $file,
            'width' => 400,
            'height' => 400,
            'type' => 'profile'
        ])->assertStatus(201);

        $uploadedImages = Image::all();
        $coverImage = $uploadedImages[0];
        $profileImage = $uploadedImages[1];

        $response = $this->get('/api/users/' . $user->id);

        $response->assertJson([
            [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,

                'cover_image' => [
                    'id' => $coverImage->id,
                    'width' => $coverImage->width,
                    'height' => $coverImage->height,
                    'type' => $coverImage->type,
                ],

                'profile_image' => [
                    'id' => $profileImage->id,
                    'width' => $profileImage->width,
                    'height' => $profileImage->height,
                    'type' => $profileImage->type,
                ]
            ],
            [
                'data' =>[],
                'links' => [
                    'self' => '/posts'
                ]
            ]
        ]);
    }
}
