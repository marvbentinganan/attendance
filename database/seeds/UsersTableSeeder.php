<?php

use Illuminate\Database\Seeder;
use App\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
        	'firstname' => "Marvin",
        	'lastname' => "Bentinganan",
        	'username' => "mebentinganan",
        	'email' => "marvbentinganan",
        	'password' => bcrypt('0822012')
        ]);
    }
}
