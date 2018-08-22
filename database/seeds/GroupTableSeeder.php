<?php

use Illuminate\Database\Seeder;
use App\Models\Group;

class GroupTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $col = Group::create([
            'name' => "College"
        ]);

        $shs = Group::create([
            'name' => "Senior High School"
        ]);
    }
}
