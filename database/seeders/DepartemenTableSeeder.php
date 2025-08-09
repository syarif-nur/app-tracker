<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class DepartemenTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('departemen')->insert([
            [
                'id' => Str::uuid(),
                'name' => 'Logistik',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => Str::uuid(),
                'name' => 'Operasional',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => Str::uuid(),
                'name' => 'Keuangan',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
