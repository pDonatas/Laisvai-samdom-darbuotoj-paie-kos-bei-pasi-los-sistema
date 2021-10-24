<?php

namespace Tests\Feature\Posts;

use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;
use App\Post;


class PostTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_see_post_create_page()
    {
        $user = User::factory()->create([
            'type' => 1
        ]);
        $this->actingAs($user);
        $response = $this->get('/posts/create');
        $response->assertSuccessful();
        $response->assertViewIs('posts.create');
    }
//    /**
//     * @depends test_user_can_see_post_create_page
//     */
//    public function test_user_can_create_post():Post
//    {
//
//        $user = User::factory()->create([
//            'type' => 1,
//            'token' => "ZEhoK1J4ME1MbEJjYzVwNEMxUy9wdnR5NUx5eXZ1aFR3NmkwL1VDRk13UT0="
//        ]);
//        $this->actingAs($user);
//        $post = Post::factory()->make();
//        $response = $this->withHeader('Authorization', 'Bearer ' . $user->token)->json
//        (
//            'post',
//            'api/posts',
//        [
//            'title' => $post->title,
//            'content' => $post->content,
//            'category' => $post->category,
//            'price' => $post->price,
//
//        ]);
//        $response->assertStatus(201);
//        return $post;
//
//    }
}
