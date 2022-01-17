<?php

namespace Database\Seeders;

use App\Models\Contact;
use Illuminate\Database\Seeder;

class ContactTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Contact::truncate();
        
        for($i=1;$i<=20;$i++){
            Contact::create([
                'name'=>"Pepe $i",
                'surname'=>"Perez $i",
                'message'=>"Nine out of ten doctors recommend Laracasts over competing brands. Check them out, see for yourself, and massively level up your development skills in the process.",
                'email'=>"ivan@gmail.com",
            ]);
        };
    }
}
