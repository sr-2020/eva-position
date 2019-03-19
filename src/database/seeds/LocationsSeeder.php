<?php

use Illuminate\Database\Seeder;

class LocationsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        App\Location::insert([
            ['id' => 1, 'label' => 'Танц-фойе Рим, 2 этаж'],
            ['id' => 2, 'label' => 'Концертный зал Москва'],
            ['id' => 3, 'label' => 'Левый коридор, 2 этаж'],
        ]);
    }
}
