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
            ['label' => 'Танц-фойе Рим, 2 этаж'],
            ['label' => 'Концертный зал Москва'],
            ['label' => 'Левый коридор, 2 этаж'],
        ]);
    }
}
