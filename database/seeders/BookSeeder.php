<?php

namespace Database\Seeders;

use App\Models\Book;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BookSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for($i = 0 ; $i<10 ; $i++){
            Book::create([
                'judul'=>fake()->sentence('5'),
                'penulis'=>fake()->name(),
                'harga'=>fake()->numberBetween(25000,250000),
                'tgl_terbit'=>fake()->date(),
            ]);
        }
    }
}
