<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Database\Seeders\TagTableSeeder;
use Database\Seeders\ContactTableSeeder;
use Database\Seeders\PostImageTableSeeder;
use Database\Seeders\PostCommentsTableSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        $this->call(CategoryTableSeeder::class);
        $this->call(PostTableSeeder::class);
        $this->call(PostImageTableSeeder::class);
        $this->call(ContactTableSeeder::class);
        $this->call(PostCommentsTableSeeder::class);
        $this->call(TagTableSeeder::class);
    }
}
