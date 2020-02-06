<?php

use Illuminate\Database\Seeder;

class CategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categories = ['Kuş Sesleri', 'Doğa Sesleri', 'Piyano Sesleri', 'Keman Sesleri'];
        foreach ($categories as $row) {
            \App\Models\Category::create([
                'name' => $row,
                'cover_image_url' => '/path/image.jpg'
            ]);
        }
    }
}
