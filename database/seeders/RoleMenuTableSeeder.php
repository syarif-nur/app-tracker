<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class RoleMenuTableSeeder extends Seeder
{
    public function run()
    {
        // Ambil semua role dan menu
        $roles = DB::table('roles')->get();
        $menus = DB::table('menus')->get();

        // Mapping permission per role
        $permissions = [
            'Creator' => [
                'Surat Jalan' => ['can_view' => true, 'can_create' => true, 'can_edit' => true],
                'Upload Bukti Serah Terima' => ['can_view' => true, 'can_create' => true],
                'Dashboard' => ['can_view' => true],
                'Scan QR/Barcode' => ['can_view' => true],
                'Log/Audit Trail' => ['can_view' => true],
                'Maps Tracking' => ['can_view' => true],
            ],
            'Admin' => [
                'Scan QR/Barcode' => ['can_view' => true, 'can_edit' => true],
                'Dashboard' => ['can_view' => true],
                'Surat Jalan' => ['can_view' => true],
                'Upload Bukti Serah Terima' => ['can_view' => true],
                'Log/Audit Trail' => ['can_view' => true],
                'Maps Tracking' => ['can_view' => true],
            ],
            'View Only' => [
                'Dashboard' => ['can_view' => true],
                'Surat Jalan' => ['can_view' => true],
                'Scan QR/Barcode' => ['can_view' => true],
                'Upload Bukti Serah Terima' => ['can_view' => true],
                'Log/Audit Trail' => ['can_view' => true],
                'Maps Tracking' => ['can_view' => true],
            ],
            'Super User' => [
                'Dashboard' => ['can_view' => true, 'can_create' => true, 'can_edit' => true, 'can_delete' => true],
                'Surat Jalan' => ['can_view' => true, 'can_create' => true, 'can_edit' => true, 'can_delete' => true],
                'Scan QR/Barcode' => ['can_view' => true, 'can_create' => true, 'can_edit' => true, 'can_delete' => true],
                'Upload Bukti Serah Terima' => ['can_view' => true, 'can_create' => true, 'can_edit' => true, 'can_delete' => true],
                'Log/Audit Trail' => ['can_view' => true, 'can_create' => true, 'can_edit' => true, 'can_delete' => true],
                'Maps Tracking' => ['can_view' => true, 'can_create' => true, 'can_edit' => true, 'can_delete' => true],
                'Pengguna' => ['can_view' => true, 'can_create' => true, 'can_edit' => true, 'can_delete' => true],
            ],
        ];

        foreach ($roles as $role) {
            foreach ($menus as $menu) {
                $perm = $permissions[$role->name][$menu->name] ?? [];
                DB::table('role_menu')->insert([
                    'id' => Str::uuid(),
                    'role_id' => $role->id,
                    'menu_id' => $menu->id,
                    'can_view' => $perm['can_view'] ?? false,
                    'can_create' => $perm['can_create'] ?? false,
                    'can_edit' => $perm['can_edit'] ?? false,
                    'can_delete' => $perm['can_delete'] ?? false,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }
}
