<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

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
            'nama' => 'Super Admin',
            'email' => 'superadmin@asus.com',
            'password' => Hash::make('SuperAdmin123'),
            'role' => 'Super Admin',
            'status' => 'Aktif',
            'remember_token' => Str::random(60),
        ]);
    }
}
