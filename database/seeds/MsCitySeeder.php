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
            'city_code' => 'JKT',
            'city_name' => 'Jakarta',
            'created_at' => \Carbon\Carbon::now()
        ]);

        DB::table('ms_city')->insert([
            'country_id' => 10,
            'city_code' => 'BJM',
            'city_name' => 'Banjarmasin',
            'created_at' => \Carbon\Carbon::now()
        ]);

        DB::table('ms_city')->insert([
            'country_id' => 10,
            'city_code' => 'SMD',
            'city_name' => 'Samarinda',
            'created_at' => \Carbon\Carbon::now()
        ]);

        DB::table('ms_city')->insert([
            'country_id' => 10,
            'city_code' => 'BPP',
            'city_name' => 'Balikpapan',
            'created_at' => \Carbon\Carbon::now()
        ]);

        DB::table('ms_city')->insert([
            'country_id' => 10,
            'city_code' => 'MKS',
            'city_name' => 'Makassar',
            'created_at' => \Carbon\Carbon::now()
        ]);

        DB::table('ms_city')->insert([
            'country_id' => 10,
            'city_code' => 'MKS',
            'city_name' => 'GW - Gowa',
            'created_at' => \Carbon\Carbon::now()
        ]);

        DB::table('ms_city')->insert([
            'country_id' => 10,
            'city_code' => 'MKS',
            'city_name' => 'KD - Kendari',
            'created_at' => \Carbon\Carbon::now()
        ]);

        DB::table('ms_city')->insert([
            'country_id' => 10,
            'city_code' => 'MKS',
            'city_name' => 'PA - Palu',
            'created_at' => \Carbon\Carbon::now()
        ]);

        DB::table('ms_city')->insert([
            'country_id' => 10,
            'city_code' => 'BJM',
            'city_name' => 'PLK - Palangkaraya',
            'created_at' => \Carbon\Carbon::now()
        ]);

        DB::table('ms_city')->insert([
            'country_id' => 10,
            'city_code' => 'BJM',
            'city_name' => 'SPT - Sampit',
            'created_at' => \Carbon\Carbon::now()
        ]);

        DB::table('ms_city')->insert([
            'country_id' => 10,
            'city_code' => 'BJM',
            'city_name' => 'BJB - Banjarbaru',
            'created_at' => \Carbon\Carbon::now()
        ]);

        DB::table('ms_city')->insert([
            'country_id' => 10,
            'city_code' => 'BJM',
            'city_name' => 'MTP - Mantapura',
            'created_at' => \Carbon\Carbon::now()
        ]);

        DB::table('ms_city')->insert([
            'country_id' => 10,
            'city_code' => 'BJM',
            'city_name' => 'BTL - Batulicin',
            'created_at' => \Carbon\Carbon::now()
        ]);
    }
}
