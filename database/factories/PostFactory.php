<?php

namespace Database\Factories;

use App\Models\Post;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class PostFactory extends Factory
{
    protected $model = Post::class;

    public function definition()
    {
        return [
			'name' => $this->faker->name,
			'category_id' => $this->faker->name,
			'description' => $this->faker->name,
			'state' => $this->faker->name,
        ];
    }
}
