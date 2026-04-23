<?php

namespace Database\Seeders;

use App\Models\Reward;
use Illuminate\Database\Seeder;

class RewardSeeder extends Seeder
{
    public function run(): void
    {
        $rewards = [
            ['name' => 'a Whey Protein 1kg', 'description' => 'Suplemen protein untuk recovery otot pasca latihan', 'point_cost' => 800, 'category' => 'suplemen', 'is_featured' => true, 'stock' => 20],
            ['name' => 'BCAA 200g', 'description' => 'Asam amino rantai cabang untuk mencegah katabolisme otot', 'point_cost' => 500, 'category' => 'suplemen', 'is_featured' => false, 'stock' => 15],
            
            ['name' => 'Gym Gloves', 'description' => 'Sarung tangan gym anti slip untuk grip lebih kuat', 'point_cost' => 400, 'category' => 'aksesoris', 'is_featured' => false, 'stock' => 25],
            ['name' => 'Lifting Belt', 'description' => 'Sabuk angkat beban untuk proteksi punggung bawah', 'point_cost' => 700, 'category' => 'aksesoris', 'is_featured' => true, 'stock' => 10],
            
            ['name' => 'Diskon Membership 50%', 'description' => 'Potongan harga 50% untuk perpanjangan membership 1 bulan', 'point_cost' => 1000, 'category' => 'diskon', 'is_featured' => true, 'stock' => 5],
            
            ['name' => 'Gym T-Shirt Exclusive', 'description' => 'Kaos olahraga dry-fit merchandise official gym', 'point_cost' => 600, 'category' => 'merchandise', 'is_featured' => false, 'stock' => 15],
            ['name' => 'Gym Bag', 'description' => 'Tas gym kapasitas 30L dengan kompartemen sepatu', 'point_cost' => 850, 'category' => 'merchandise', 'is_featured' => true, 'stock' => 10],
        ];

        foreach ($rewards as $reward) {
            Reward::firstOrCreate(['name' => $reward['name']], array_merge($reward, ['is_active' => true]));
        }
    }
}
