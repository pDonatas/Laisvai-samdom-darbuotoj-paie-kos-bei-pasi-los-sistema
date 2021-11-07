<?php

namespace Tests\Feature\Posts;

use App\Http\Services\Auth\TokenService;
use App\Http\Services\TagsService;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use Tests\TestCase;
use App\Post;


class PostTest extends TestCase
{

    public function test_user_can_view_post_index_page()
    {
        $user = User::factory()->create([
            'type' => 1,
            'token' => (new TokenService)->encryptToken(json_encode(['expire' => strtotime('+2 days')]))
        ]);
        $this->actingAs($user);
        $response = $this->withHeader('Authorization', 'Bearer ' . $user->token)->getJson('/api/posts');
        $response->assertStatus(200);
    }
    public function test_user_can_create_post(): array
    {

        $user = User::factory()->create([
            'type' => 1,
            'token' => (new TokenService)->encryptToken(json_encode(['expire' => strtotime('+2 days')]))
        ]);
        $this->actingAs($user);
        $post = Post::factory()->make();
        $img = UploadedFile::fake()->create('image.png');
        $response = $this->withHeader('Authorization', 'Bearer ' . $user->token)->postJson(
            'api/posts',
        [
            'title' => $post->title,
            'content' => $post->content,
            'category' => $post->category,
            'price' => $post->price,
            'img' => $img

        ]);
        $response->assertStatus(201);
        $data = ["user" => $user, "post" => "$post"];
        return $data;

    }

    public function test_user_cant_create_post_not_authenticated()
    {
        $user = User::factory()->create([
            'type' => 1,
        ]);
        $this->actingAs($user);
        $post = Post::factory()->make();
        $img = UploadedFile::fake()->create('image.png');
        $response = $this->post('api/posts', [
                'title' => $post->title,
                'content' => $post->content,
                'category' => $post->category,
                'price' => $post->price,
                'img' => $img
            ]);
        $response->assertStatus(401);
    }
    /**
     * @depends test_user_can_create_post
     */
    public function test_user_can_view_post(array $array)
    {

        $post = json_decode($array['post']);
        $post = Post::where('title', $post->title)->first();
        $user = $array['user'];
        $token = "YWsvb3pXRXlONUpuQTE0OWlrc1NzMlRxVmtVQkhZQW9sSGNManRLbjlJVT0=";
        $response = $this->withHeader('Authorization', 'Bearer ' . $user->token)->getJson( 'api/posts/'. $post->slug);
        $response->assertStatus(200);

    }
    /**
     * @depends test_user_can_create_post
     */
    public function test_user_cant_view_post_because_it_doesnt_exist(array $array)
    {

        $user = $array['user'];
        $slug = "naujas";
        $token = "YWsvb3pXRXlONUpuQTE0OWlrc1NzMlRxVmtVQkhZQW9sSGNManRLbjlJVT0=";
        $response = $this->withHeader('Authorization', 'Bearer ' . $user->token)->getJson( 'api/posts/'. $slug);
        $response->assertStatus(404);

    }
    /**
     * @depends test_user_can_create_post
     */

    public function test_user_cant_update_post_it_doesnt_exist(array $array)
    {

        $user = $array['user'];
        $slug = "naujas";
        $token = "YWsvb3pXRXlONUpuQTE0OWlrc1NzMlRxVmtVQkhZQW9sSGNManRLbjlJVT0=";
        $response = $this->withHeader('Authorization', 'Bearer ' . $user->token)->patchJson('api/posts/'. $slug,
            [
                'title' => 'new title',
                'content' => 'new content',
                'category' => "2",
                'price' => 1,
            ]);
        $response->assertStatus(404);

    }
    /**
     * @depends test_user_can_create_post
     */

    public function test_user_cant_update_other_user_post(array $array)
    {
        $user = User::factory()->create([
            'type' => 1,
            'token' => (new TokenService)->encryptToken(json_encode(['expire' => strtotime('+4 days')]))
        ]);
        $post = json_decode($array['post']);
        $post = Post::where('title', $post->title)->first();
        $token = "YWsvb3pXRXlONUpuQTE0OWlrc1NzMlRxVmtVQkhZQW9sSGNManRLbjlJVT0=";
        $response = $this->withHeader('Authorization', 'Bearer ' . $user->token)->patchJson('api/posts/'. $post->slug,
            [
                'title' => 'new title',
                'content' => 'new content',
                'category' => "2",
                'price' => 1,
            ]);
        $response->assertStatus(403);

    }
    /**
     * @depends test_user_can_create_post
     */

    public function test_user_can_update_post(array $array)
    {
        $post = json_decode($array['post']);
        $post = Post::where('title', $post->title)->first();
        $user = $array['user'];
        $token = "YWsvb3pXRXlONUpuQTE0OWlrc1NzMlRxVmtVQkhZQW9sSGNManRLbjlJVT0=";
        $response = $this->withHeader('Authorization', 'Bearer ' . $user->token)->patchJson('api/posts/'. $post->slug,
            [
                'title' => 'new title',
                'content' => 'new content',
                'category' => "2",
                'price' => 1,

            ]);
        $response->assertStatus(200);

    }
    /**
     * @depends test_user_can_create_post
     */

    public function test_user_cant_delete_other_user_post()
    {

        $user = User::factory()->create([
            'type' => 1,
            'token' => (new TokenService)->encryptToken(json_encode(['expire' => strtotime('+3 days')]))
        ]);
        $post = Post::where('title', 'new title')->first();
        $response = $this->withHeader('Authorization', 'Bearer ' . $user->token)->deleteJson('api/posts/'. $post->slug);
        $response->assertStatus(403);
    }
    /**
     * @depends test_user_can_create_post
     */

    public function test_user_cant_delete_post_it_doesnt_exist(array $array)
    {
        $user = $array['user'];
        $slug = "naujas";
        $response = $this->withHeader('Authorization', 'Bearer ' . $user->token)->deleteJson('api/posts/'. $slug);
        $response->assertStatus(404);
    }
    /**
     * @depends test_user_can_create_post
     */
    public function test_user_can_delete_post(array $array)
    {
        $user = $array['user'];
        $post = Post::where('title', 'new title')->first();
        $response = $this->withHeader('Authorization', 'Bearer ' . $user->token)->deleteJson('api/posts/'. $post->slug);
        $response->assertStatus(204);
    }

}
