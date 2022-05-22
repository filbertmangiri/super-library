<?php

namespace Database\Seeders;

use App\Models\Book;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BookSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Book::factory(100)->create();

        Book::factory(50, [
            'synopsis' => 'Lorem ipsum dolor sit, amet consectetur adipisicing elit. Officia expedita nisi nobis, ut dolor obcaecati fugiat, mollitia praesentium maxime inventore perferendis voluptatum consequuntur repudiandae ipsam! Quam, nesciunt! Nisi, debitis ducimus.',
            'category_id' => 7
        ])->create();
    }
}
