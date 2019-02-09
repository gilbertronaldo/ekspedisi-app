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
        DB::statement("TRUNCATE TABLE t_role_task RESTART IDENTITY CASCADE;");
        DB::statement("TRUNCATE TABLE t_task RESTART IDENTITY CASCADE;");

        DB::statement("TRUNCATE TABLE t_user_role RESTART IDENTITY CASCADE;");
        DB::statement("TRUNCATE TABLE t_role RESTART IDENTITY CASCADE;");
        DB::statement("TRUNCATE TABLE users RESTART IDENTITY CASCADE;");


        $this->seedUser();
        $this->seedRole();
        $this->seedUserRole();

        $this->seedTask();
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

    private function seedTask()
    {
        $data = [
          [
            'task_code'        => 'USER_NAVIGATION_SIDEBAR',
            'task_description' => 'Menampilkan Menu User di navigation',
          ],
          [
            'task_code'        => 'USER_ADD',
            'task_description' => 'Menambahkan Data User',
          ],
          [
            'task_code'        => 'USER_EDIT',
            'task_description' => 'Mengedit Data User',
          ],
          [
            'task_code'        => 'USER_DELETE',
            'task_description' => 'Menghapus Data Delete',
          ],
          [
            'task_code'        => 'USER_MANAGE_ROLES',
            'task_description' => 'Manage User Roles',
          ],
          [
            'task_code'        => 'SHIP_NAVIGATION_SIDEBAR',
            'task_description' => 'Menampilkan Menu Kapal di navigation',
          ],
          [
            'task_code'        => 'SHIP_ADD',
            'task_description' => 'Menambahkan Data Kapal',
          ],
          [
            'task_code'        => 'SHIP_EDIT',
            'task_description' => 'Mengedit Data Kapal',
          ],
          [
            'task_code'        => 'SHIP_DELETE',
            'task_description' => 'Menghapus Data Kapal',
          ],
          [
            'task_code'        => 'RECIPIENT_NAVIGATION_SIDEBAR',
            'task_description' => 'Menampilkan Menu Penerima di navigation',
          ],
          [
            'task_code'        => 'RECIPIENT_ADD',
            'task_description' => 'Menambahkan Data Penerima',
          ],
          [
            'task_code'        => 'RECIPIENT_EDIT',
            'task_description' => 'Mengedit Data Penerima',
          ],
          [
            'task_code'        => 'RECIPIENT_DELETE',
            'task_description' => 'Menghapus Data Penerima',
          ],
          [
            'task_code'        => 'SENDER_NAVIGATION_SIDEBAR',
            'task_description' => 'Menampilkan Menu Pengirim di navigation',
          ],
          [
            'task_code'        => 'SENDER_ADD',
            'task_description' => 'Menambahkan Data Pengirim',
          ],
          [
            'task_code'        => 'SENDER_EDIT',
            'task_description' => 'Mengedit Data Pengirim',
          ],
          [
            'task_code'        => 'SENDER_DELETE',
            'task_description' => 'Menghapus Data Pengirim',
          ],

          [
            'task_code'        => 'BAPB_NAVIGATION_SIDEBAR',
            'task_description' => 'Menampilkan Menu BAPB di navigation',
          ],
          [
            'task_code'        => 'BAPB_INPUT',
            'task_description' => 'Input data BAPB',
          ],
          [
            'task_code'        => 'BAPB_DELETE',
            'task_description' => 'Delete data BAPB',
          ],
          [
            'task_code'        => 'BAPB_PRINT_PDF',
            'task_description' => 'Print Hasil PDF BAPB',
          ],
          [
            'task_code'        => 'BAPB_VERIFY',
            'task_description' => 'Verify data BAPB',
          ],
          [
            'task_code'        => 'INVOICE_NAVIGATION_SIDEBAR',
            'task_description' => 'Menampilkan Menu Invoice di navigation',
          ],
          [
            'task_code'        => 'INVOICE_ADD',
            'task_description' => 'Menambah data invoice',
          ],
          [
            'task_code'        => 'INVOICE_DELETE',
            'task_description' => 'Hapus data invoice',
          ],
          [
            'task_code'        => 'INVOICE_PRINT_INVOICE',
            'task_description' => 'Print Hasil PDF Invoice',
          ],
          [
            'task_code'        => 'INVOICE_PRINT_KWITANSI',
            'task_description' => 'Print Hasil PDF Kwitansi',
          ],
          [
            'task_code'        => 'PAYMENT_NAVIGATION_SIDEBAR',
            'task_description' => 'Menampilkan Menu Payment di navigation',
          ],
          [
            'task_code'        => 'CONTAINER_NAVIGATION_SIDEBAR',
            'task_description' => 'Menampilkan Menu Container di navigation',
          ],
          [
            'task_code'        => 'CONTAINER_PRINT_EXCEL',
            'task_description' => 'Export to excel Container',
          ],
        ];

        $data = collect($data)->map(
          function ($i)
          {
              return [
                'task_code'        => strtoupper($i['task_code']),
                'task_description' => strtoupper($i['task_description']),
                'created_at'       => \Carbon\Carbon::now(),
              ];
          }
        );

        DB::table('t_task')->insert($data->toArray());
    }
}
