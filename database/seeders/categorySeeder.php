<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class categorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if (!DB::table('category')->where('name', 'TPV')->exists()) {
            DB::table('category')->insert([
                [
                    'name' => 'TPV',
                    'description' => 'Thực Phẩm Vàng',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'name' => 'Milk',
                    'description' => 'Sữa',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
            ]);
        }        
    }
}
