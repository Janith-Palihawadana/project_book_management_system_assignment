<?php

namespace Database\Seeders;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoleTableSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('roles')->truncate();
        DB::table('roles')->insert(array (
            0 =>
                array (
                    'id' => 1,
                    'role' => 'Admin',
                    'key' => '6112E7',
                    'is_active' => 1,
                ),
            1 =>
                array (
                    'id' => 2,
                    'role' => 'Author',
                    'key' => 'C25769',
                    'is_active' => 1,
                )
        ));
    }
}
