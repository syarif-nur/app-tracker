<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UsersTableSeeder extends Seeder
{
    public function run()
    {
        $roleId = DB::table('roles')->where('is_super_user', true)->value('id');

        DB::table('users')->insert([
            [
                'id' => Str::uuid(),
                'name' => 'Super Admin',
                'email' => 'super_user@tiberman.com',
                'password' => Hash::make('A1b!2c3d'), // 8 karakter, kombinasi
                'departemen_id' => null,
                'role_id' => $roleId,
                'remember_token' => Str::random(10),
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
