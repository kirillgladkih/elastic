<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class ArticleFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $tags = collect(["js", "php", "c#", "ruby", "scala", "c++"])
            ->random(3)
            ->values()
            ->all();

        $max = User::where("id", ">", 0)->count();

        $id = rand(1, $max - 1);

        return [
            "body" => $this->faker->text(),
            "title" => $this->faker->text(20),
            "tags" => $tags,
            "user_id" => $id
        ];
    }
}
