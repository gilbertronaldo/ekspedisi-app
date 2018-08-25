<?php

use Illuminate\Database\Seeder;

class MsCountrySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('ms_country')->insert([
            'country_id' => 10,
            'country_code' => 'IDN',
            'country_name' => 'Indonesia',
            'created_at' => \Carbon\Carbon::now()
        ]);
    }
}
