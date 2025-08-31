<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Category::create([
            'name' => 'Elektronik',
            'description' => 'Cep telefonları, bilgisayarlar ve diğer elektronik cihazlar.',
        ]);

        Category::create([
            'name' => 'Ev ve Yaşam',
            'description' => 'Ev dekorasyon ürünleri, mobilyalar ve mutfak gereçleri.',
        ]);

        Category::create([
            'name' => 'Kitap',
            'description' => 'Farklı türlerde romanlar, ders kitapları ve dergiler.',
        ]);

        Category::create([
            'name' => 'Oto, Bahçe ve Yapı Market',
            'description' => 'Otomotiv ürünleri, bahçe gereçleri ve yapı malzeme ürünleri.',
        ]);
    }
}