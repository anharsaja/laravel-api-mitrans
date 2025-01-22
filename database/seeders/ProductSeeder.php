<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Product::create([
            'name' => 'Meja Makan Kayu Jati',
            'description' => 'Meja makan berbahan kayu jati berkualitas tinggi, cocok untuk ruang makan Anda.',
            'price' => 2500000, // Harga dalam Rupiah
            'quantity' => 10,
        ]);
        
        Product::create([
            'name' => 'Kursi Sofa Minimalis',
            'description' => 'Sofa minimalis dengan bantalan empuk, cocok untuk ruang tamu Anda.',
            'price' => 1500000, // Harga dalam Rupiah
            'quantity' => 15,
        ]);
        
        Product::create([
            'name' => 'Lemari Pakaian 2 Pintu',
            'description' => 'Lemari pakaian dengan desain elegan dan kapasitas besar.',
            'price' => 2000000, // Harga dalam Rupiah
            'quantity' => 8,
        ]);
        
        Product::create([
            'name' => 'Rak Buku Kayu',
            'description' => 'Rak buku berbahan kayu solid dengan desain modern.',
            'price' => 500000, // Harga dalam Rupiah
            'quantity' => 20,
        ]);
        
        Product::create([
            'name' => 'Lampu Gantung Hias',
            'description' => 'Lampu gantung dengan desain artistik untuk ruang makan atau ruang tamu.',
            'price' => 350000, // Harga dalam Rupiah
            'quantity' => 30,
        ]);
        
    }
}
