<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ShiftsTableSeeder extends Seeder
{
    public function run(): void
    {
        // Ambil id pegawai berdasarkan handle (hindari hardcoded ID)
        $handles = ['@ashley','@stephen','@richard_walt','@michael'];
        $ids = DB::table('employees')->whereIn('handle', $handles)->pluck('id', 'handle');

        // Minggu aktif (mulai Senin) – biar pasti muncul di grid 2 minggu kamu
        $monday = Carbon::now()->startOfWeek(Carbon::MONDAY);

        // Definisi shift relatif ke Senin (offset = +hari)
        $rows = [
            ['handle' => '@ashley',       'offset' => 0, 'start' => '09:00:00', 'end' => '12:00:00', 'label' => 'Loket Kanwil', 'color' => 'teal'],
            ['handle' => '@stephen',      'offset' => 1, 'start' => '13:00:00', 'end' => '17:00:00', 'label' => '1',             'color' => 'rose'],
            ['handle' => '@richard_walt', 'offset' => 2, 'start' => '08:00:00', 'end' => '12:00:00', 'label' => '4',             'color' => 'teal'],
            ['handle' => '@michael',      'offset' => 2, 'start' => '14:00:00', 'end' => '16:00:00', 'label' => '2',             'color' => 'indigo'],
        ];

        foreach ($rows as $r) {
            $empId = $ids[$r['handle']] ?? null;
            if (!$empId) continue; // lewati kalau pegawai belum ada

            $date = $monday->copy()->addDays($r['offset'])->toDateString();

            // Idempotent: unik di (employee_id + date + start)
            DB::table('shifts')->updateOrInsert(
                ['employee_id' => $empId, 'date' => $date, 'start' => $r['start']],
                [
                    'end'        => $r['end'],
                    'label'      => $r['label'],
                    'color'      => $r['color'],
                    'created_at' => now(),
                    'updated_at' => now(),
                ]
            );
        }
    }
}
