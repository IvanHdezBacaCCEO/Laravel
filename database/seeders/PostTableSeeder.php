<?php

namespace Database\Seeders;

use App\Models\Post;
use App\Models\Category;
use Illuminate\Database\Seeder;

class PostTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Post::truncate();
        $categories = Category::all();
        foreach ($categories as $key => $c) {
            for($i=1;$i<=20;$i++){
                Post::create([
                    'title'=>"Post $i $key",
                    'url_clean'=>"post-$i-$key",
                    'content'=>"Nine out of ten doctors recommend Laracasts over competing brands. Check them out, see for yourself, and massively level up your development skills in the process.",
                    'posted'=>"yes",
                    'category_id'=>$c->id
                ]);
            };
        }
    }
}
