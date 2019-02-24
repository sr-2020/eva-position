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
        $user->email = 'api-test@email.com';
        $user->password = 'TERSQTNQRHF';
        $user->api_key = 'TkRVem4yTERSQTNQRHFxcmo4SUozNWZp';
        $user->beacon_id = 1;
        $user->save();

        $user = factory(App\User::class)->make();
        $user->email = 'test@email.com';
        $user->password = 'secret';
        $user->beacon_id = 1;
        $user->save();

        $user = factory(App\User::class)->make();
        $user->email = 'user-for-delete-test@email.com';
        $user->password = 'secret';
        $user->save();
    }
}
