<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call('LocationsSeeder');
        $this->call('LayersSeeder');
        $this->call('BeaconsSeeder');
        $this->call('UsersSeeder');
    }
}
