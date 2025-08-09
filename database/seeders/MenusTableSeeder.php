<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class MenusTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('menus')->insert([
            [
                'id' => Str::uuid(),
                'name' => 'Pengguna',
                'route' => '/users',
                'icon' => 'users',
                'order' => 7,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => Str::uuid(),
                'name' => 'Roles',
                'route' => '/roles',
                'icon' => 'shield',
                'order' => 8,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => Str::uuid(),
                'name' => 'Dashboard',
                'route' => '/dashboard',
                'icon' => 'home',
                'order' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => Str::uuid(),
                'name' => 'Surat Jalan',
                'route' => '/delivery-orders',
                'icon' => 'file-text',
                'order' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => Str::uuid(),
                'name' => 'Scan QR/Barcode',
                'route' => '/scan',
                'icon' => 'qrcode',
                'order' => 3,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => Str::uuid(),
                'name' => 'Upload Bukti Serah Terima',
                'route' => '/upload-proof',
                'icon' => 'upload',
                'order' => 4,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => Str::uuid(),
                'name' => 'Log/Audit Trail',
                'route' => '/logs',
                'icon' => 'list',
                'order' => 5,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => Str::uuid(),
                'name' => 'Maps Tracking',
                'route' => '/maps',
                'icon' => 'map',
                'order' => 6,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
