<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\Menu;
use App\Models\Promo;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run()
    {
        // Admin
        User::create([
            'name' => 'Admin YukJajan',
            'email' => 'admin@yukjajan.com',
            'password' => bcrypt('password123'),
            'role' => 'admin'
        ]);

        // User biasa
        User::create([
            'name' => 'User Biasa',
            'email' => 'user@yukjajan.com',
            'password' => bcrypt('password123'),
            'role' => 'user'
        ]);

        // Kategori
        $kopi = Category::create(['name' => 'Kopi']);
        $makanan = Category::create(['name' => 'Makanan Berat']);

        // Menu
        $menu1 = Menu::create([
            'category_id' => $kopi->id,
            'name' => 'Kopi Susu',
            'price' => 12000,
            'is_available' => true
        ]);

         Menu::create([
            'category_id' => $makanan->id,
            'name' => 'Mie Ayam',
            'price' => 18000,
            'is_available' => true
        ]);
        Menu::create([
            'category_id' => $kopi->id,
            'name' => 'Americano',
            'price' => 15000,
            'is_available' => true
        ]);
        Menu::create([
            'category_id' => $makanan->id,
            'name' => 'Nasi Goreng',
            'price' => 20000,
            'is_available' => true
        ]);
        Menu::create([
            'category_id' => $kopi->id,
            'name' => 'Cappuccino',
            'price' => 16000,
            'is_available' => true
        ]);

        // Promo hari ini
        Promo::create([
            'title' => 'Promo Pagi Hemat',
            'discount_percent' => 20,
            'applied_menu_id' => $menu1->id,
            'start_date' => now()->toDateString(),
            'end_date' => now()->toDateString()
        ]);
    }
}
