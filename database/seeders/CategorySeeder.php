<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $categories = [
            ['c_name' => 'cat1'],
            ['c_name' => 'cat2'],
            ['c_name' => 'cat3']
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}
