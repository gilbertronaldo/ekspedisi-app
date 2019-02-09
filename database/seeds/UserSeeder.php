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
        DB::statement("TRUNCATE TABLE t_user_role RESTART IDENTITY CASCADE;");
        DB::statement("TRUNCATE TABLE t_role RESTART IDENTITY CASCADE;");
        DB::statement("TRUNCATE TABLE users RESTART IDENTITY CASCADE;");


        $this->seedUser();
        $this->seedRole();
        $this->seedUserRole();
    }

    private function seedUser()
    {
        DB::table('users')->insert(
          [
            'name'       => 'Gilbert Ronaldo',
            'email'      => 'superadmin',
            'password'   => bcrypt('superadmin'),
            'created_at' => \Carbon\Carbon::now(),
          ]
        );

        DB::table('users')->insert(
          [
            'name'       => 'admin',
            'email'      => 'admin',
            'password'   => bcrypt('password'),
            'created_at' => \Carbon\Carbon::now(),
          ]
        );
    }

    private function seedRole()
    {
        DB::table('t_role')->insert(
          [
            'role_name'  => 'SUPERADMIN',
            'created_at' => \Carbon\Carbon::now(),
          ]
        );

        DB::table('t_role')->insert(
          [
            'role_name'  => 'ADMIN',
            'created_at' => \Carbon\Carbon::now(),
          ]
        );

        DB::table('t_role')->insert(
          [
            'role_name'  => 'STAFF',
            'created_at' => \Carbon\Carbon::now(),
          ]
        );
    }


    private function seedUserRole()
    {
        DB::table('t_user_role')->insert(
          [
            'user_id'    => 2,
            'role_id'    => 2,
            'city_code'  => 'JKT',
            'created_at' => \Carbon\Carbon::now(),
          ]
        );
    }
}
