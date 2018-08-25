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
            'city_code' => 'BDG',
            'city_name' => 'Bandung',
            'created_at' => \Carbon\Carbon::now()
        ]);

        DB::table('ms_city')->insert([
            'country_id' => 10,
            'city_code' => 'SBY',
            'city_name' => 'Surabaya',
            'created_at' => \Carbon\Carbon::now()
        ]);

        DB::table('ms_city')->insert([
            'country_id' => 10,
            'city_code' => 'YYK',
            'city_name' => 'Yogyakarta',
            'created_at' => \Carbon\Carbon::now()
        ]);

        DB::table('ms_city')->insert([
            'country_id' => 10,
            'city_code' => 'SMG',
            'city_name' => 'Semarang',
            'created_at' => \Carbon\Carbon::now()
        ]);

        DB::table('ms_city')->insert([
            'country_id' => 10,
            'city_code' => 'MND',
            'city_name' => 'Manado',
            'created_at' => \Carbon\Carbon::now()
        ]);

        DB::table('ms_city')->insert([
            'country_id' => 10,
            'city_code' => 'BNA',
            'city_name' => 'Banda Aceh',
            'created_at' => \Carbon\Carbon::now()
        ]);


        DB::table('ms_city')->insert([
            'country_id' => 10,
            'city_code' => 'MKS',
            'city_name' => 'Makassar',
            'created_at' => \Carbon\Carbon::now()
        ]);
    }
}
