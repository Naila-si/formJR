<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EmployeesTableSeeder extends Seeder
{
    public function run(): void
    {
        $centers = DB::table('work_centers')->pluck('id','slug');
        
        $rows = [
            ['name' => 'Ashley Brown',    'handle' => '@ashley',       'avatar_url' => 'https://i.pravatar.cc/64?img=1'],
            ['name' => 'Javier Holloway', 'handle' => '@j_holloway',   'avatar_url' => 'https://i.pravatar.cc/64?img=2'],
            ['name' => 'Stephen Harris',  'handle' => '@stephen',      'avatar_url' => 'https://i.pravatar.cc/64?img=3'],
            ['name' => 'Richard Walters', 'handle' => '@richard_walt', 'avatar_url' => 'https://i.pravatar.cc/64?img=4'],
            ['name' => 'Michael Simon',   'handle' => '@michael',      'avatar_url' => 'https://i.pravatar.cc/64?img=5'],
        ];

        foreach ($rows as $r) {
            DB::table('employees')->updateOrInsert(
                ['handle' => $r['handle']],                          // kunci unik logis
                $r + ['created_at' => now(), 'updated_at' => now()]  // data yang di-update/insert
            );
        }
    }
}
