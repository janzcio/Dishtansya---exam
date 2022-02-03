<?php


namespace Database\Seeders;

use Faker\Factory as Faker;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('products')->truncate();
        DB::table('ordered_products')->truncate();

        $faker = Faker::create();

        $products = [];
        
        try {
            DB::beginTransaction();
            foreach(range(1, 100) as $value){
                $products[] = [
                    "name" => $faker->word,
                    "available_stock" => rand(0, 10),
                    "created_at" => now()
                ];
            }

            $productChunks = array_chunk($products, 100);

            DB::table('products')->insert($productChunks[0]);

            DB::commit();
        } catch (\Exception $e) {
            info('error seeding');
            DB::rollBack();
            dd($e->getMessage());
        }
    }
}
