<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $products = [
            ['p_name' => 'prod1'],
            ['p_name' => 'prod2'],
            ['p_name' => 'prod3']
        ];

        foreach ($products as $product) {
            Product::create($product);
        }
    }
}
