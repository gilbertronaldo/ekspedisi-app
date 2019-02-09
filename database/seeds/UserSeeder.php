<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Truncate data
        DB::table('users')->truncate();


        DB::table('users')->insert([
            'name' => 'Gilbert Ronaldo',
            'email' => 'superadmin',
            'password' => bcrypt('superadmin'),
            'created_at' => \Carbon\Carbon::now()
        ]);

        DB::table('users')->insert([
            'name' => 'admin',
            'email' => 'admin',
            'password' => bcrypt('password'),
            'created_at' => \Carbon\Carbon::now()
        ]);
    }

    private function seedRole()
    {

    }

    private function seedTask()
    {

    }

    private function seedRoleTask()
    {

    }
}
