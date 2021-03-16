<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Post;
use App\Models\Categorie;


class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Post::factory()->count(50)->create()->each(function ($post){
            $categorie = Categorie::all()->random()->id;

            //dd($categorie);
            $post->categories()->attach($categorie);
        });
    }
}
