<?php

namespace Database\Factories;

use App\Post;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Auth;

class PostFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Post::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'title' => 'Title',
            'content' => 'Siuloma pagalba IT srityje',
            'category' => '1',
            'slug' => 'naujas',
            'user_id' => Auth::id(),
            'price' => 5,
        ];
    }
}
