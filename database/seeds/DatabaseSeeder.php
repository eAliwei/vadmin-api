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
        App\User::create([
            'name' => 'VAdmin',
            'email' => 'vadmin@gmail.com',
            'password' => app('hash')->make('123456')
        ]);
        // $this->call('UsersTableSeeder');
    }
}
