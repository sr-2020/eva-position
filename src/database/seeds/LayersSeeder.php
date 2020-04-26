<?php

use Illuminate\Database\Seeder;

class LayersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        App\Layer::insert([
            ['name' => 'Level 1'],
            ['name' => 'Level 2'],
            ['name' => 'Level 3'],
        ]);
    }
}
