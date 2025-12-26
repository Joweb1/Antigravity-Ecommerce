<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\Product; // Import the Product model
use Illuminate\Support\Str; // For slug generation

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Product::create([
            'name' => 'Antigravity Hoverboard',
            'slug' => Str::slug('Antigravity Hoverboard'),
            'description' => 'Experience the thrill of zero-G with our state-of-the-art hoverboard.',
            'price' => 120000, // $1200.00
            'stock_quantity' => 10,
            'image_path' => 'products/hoverboard.jpg',
        ]);

        Product::create([
            'name' => 'Quantum Leap Drive',
            'slug' => Str::slug('Quantum Leap Drive'),
            'description' => 'Instantaneous interstellar travel now at your fingertips.',
            'price' => 500000, // $5000.00
            'stock_quantity' => 5,
            'image_path' => 'products/quantum-drive.jpg',
        ]);

        Product::create([
            'name' => 'Neuro-Enhancement Helmet',
            'slug' => Str::slug('Neuro-Enhancement Helmet'),
            'description' => 'Boost your cognitive functions and unlock your full potential.',
            'price' => 30000, // $300.00
            'stock_quantity' => 20,
            'image_path' => 'products/neuro-helmet.jpg',
        ]);

Product::create([
            'name' => 'Ionic Blaster Pistol',
            'slug' => Str::slug('Ionic Blaster Pistol'),
            'description' => 'Compact and powerful, perfect for self-defense in the outer rims.',
            'price' => 8000, // $80.00
            'stock_quantity' => 50,
            'image_path' => 'products/blaster-pistol.jpg',
        ]);

        Product::create([
            'name' => 'Personal Force Field Generator',
            'slug' => Str::slug('Personal Force Field Generator'),
            'description' => 'Stay safe in hostile environments with a portable energy shield.',
            'price' => 25000, // $250.00
            'stock_quantity' => 15,
            'image_path' => 'products/force-field.jpg',
        ]);
    }
}