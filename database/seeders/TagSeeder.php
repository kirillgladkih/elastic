<?php

namespace Database\Seeders;

use App\Models\Tag;
use Illuminate\Database\Seeder;

class TagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $tags = [
            "php", "js", "c#", "c++", "scala", "lua", "sql", "java", "perl"
        ];

        foreach ($tags as $tag){
            Tag::create(["name" => $tag]);
        }
    }
}
