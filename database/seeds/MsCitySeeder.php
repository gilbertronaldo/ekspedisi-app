<?php

use Illuminate\Database\Seeder;

class MsCitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('ms_city')->insert([
            'country_id' => 10,
            'city_code' => 'JB',
            'city_name' => 'Banjarmasin',
            'created_at' => \Carbon\Carbon::now()
        ]);

        DB::table('ms_city')->insert([
            'country_id' => 10,
            'city_code' => 'JM',
            'city_name' => 'Samarinda',
            'created_at' => \Carbon\Carbon::now()
        ]);

        DB::table('ms_city')->insert([
            'country_id' => 10,
            'city_code' => 'JP',
            'city_name' => 'Balikpapan',
            'created_at' => \Carbon\Carbon::now()
        ]);

        DB::table('ms_city')->insert([
            'country_id' => 10,
            'city_code' => 'JK',
            'city_name' => 'Makassar',
            'created_at' => \Carbon\Carbon::now()
        ]);
    }
}
