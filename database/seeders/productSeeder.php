<?php

namespace Database\Seeders;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class productSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // DB::table('product1')->insert([
        //     [
        //         'name' => 'Sữa Hạt Dinh Dưỡng',
        //         'price' => 100000,
        //         'image' => 'product1.jpg',
        //         'cate_id' => 2,
        //         'created_at' => now(),
        //         'updated_at' => now(),
        //     ],
        //     [
        //         'name' => 'Thuốc Bổ Sung Vitamin E',
        //         'price' => 200000,
        //         'image' => 'product2.jpg',
        //         'cate_id' => 1,
        //         'created_at' => now(),
        //         'updated_at' => now(),
        //     ],
        // ]);

        $faker = Faker::create();

        foreach (range(1,100) as $index) {
            DB::table('product1')->insert([
                'name' => $faker->unique()->word,
                'price' => $faker->numberBetween(5000, 200000), 
                'image' => $faker->imageUrl(200, 200, 'food'), 
                'cate_id' => 2, 
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }
    }
}
