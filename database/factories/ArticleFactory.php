<?php

namespace Database\Factories;

use App\Models\Tag;
use App\Models\User;
use Carbon\Carbon;
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
        $tags = Tag::all("id")->toArray();

        $tags = collect($tags)
            ->random(3)
            ->values()
            ->all();

        $tagResult = [];

        foreach($tags as $tag)
            $tagResult[] = $tag["id"];

        $created_at = Carbon::today()->subDays(rand(0, 365))->toString();

        $max = User::where("id", ">", 0)->count();

        $id = rand(1, $max - 1);

        return [
            "body" => $this->faker->text(),
            "title" => $this->faker->text(20),
            "tags" => $tagResult,
            "user_id" => $id,
            "created_at" => $created_at
        ];
    }
}
