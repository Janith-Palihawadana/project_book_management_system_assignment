<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

class UsersTableSeeder extends Seeder
{
    public function run(): void
    {
        Schema::disableForeignKeyConstraints();
        User::truncate();
        Schema::enableForeignKeyConstraints();

        User::create([
            'role_id' => 1,
            'email' => 'admin@gmail.com',
            'name' => 'Admin',
            'password' => bcrypt('admin@123'),
        ]);
    }
}
