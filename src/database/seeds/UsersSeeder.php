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
        $user->email = 'admin@evarun.ru';
        $user->password = 'secret';
        $user->api_key = 'TkRVem4yTERSQTNQRHFxcmo4SUozNWZp';
        $user->save();
    }
}
