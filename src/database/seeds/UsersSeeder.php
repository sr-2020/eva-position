<?php

use Illuminate\Database\Seeder;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = factory(App\User::class)->make();
        $user->name = 'Мистер X';
        $user->email = 'test@email.com';
        $user->password = 'secret';
        $user->save();
    }
}
