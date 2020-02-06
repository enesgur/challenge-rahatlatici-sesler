<?php

use Illuminate\Database\Seeder;

class SongsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = \Faker\Factory::create();
        $artists = \App\Models\Artist::all();
        $categories = \App\Models\Category::all();
        for ($i = 0; $i < 200; $i++) {
            $artist = $artists->random(1);
            $category = $categories->random(1);
            $song = \App\Models\Song::create([
                'aid' => $artist[0]->id,
                'length' => $faker->numberBetween(200, 400),
                'name' => $faker->words('3', true),
                'stream_url' => '/stream/object/' . $faker->word . '.mp3/playlist.m3u8',
            ]);

            \App\Models\CategorySong::create([
                'sid' => $song->id,
                'cid' => $category[0]->id
            ]);
        }
    }
}
