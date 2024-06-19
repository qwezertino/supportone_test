<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Association;

class AssociationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $associations = [
            ['c_id' => 1, 'p_id' => 1],
            ['c_id' => 1, 'p_id' => 2],
            ['c_id' => 2, 'p_id' => 1],
            ['c_id' => 3, 'p_id' => 2],
            ['c_id' => 3, 'p_id' => 3]
        ];

        foreach ($associations as $association) {
            Association::create($association);
        }
    }
}
