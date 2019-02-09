<?php

use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name' => 'Gilbert Ronaldo',
            'email' => 'me@gilbertronaldo.com',
            'password' => bcrypt('password'),
            'created_at' => \Carbon\Carbon::now()
        ]);

        DB::table('users')->insert([
            'name' => 'admin',
            'email' => 'admin',
            'password' => bcrypt('password'),
            'created_at' => \Carbon\Carbon::now()
        ]);
    }
}
