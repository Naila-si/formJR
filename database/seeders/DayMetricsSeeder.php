<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\DayMetric;
use Carbon\Carbon;

class DayMetricsSeeder extends Seeder
{
    public function run(): void
    {
        $start = Carbon::now()->startOfWeek(Carbon::MONDAY);

        for ($i = 0; $i < 14; $i++) {
            $date = $start->copy()->addDays($i)->toDateString();

            DayMetric::updateOrCreate(
                ['date' => $date], // <- pastikan kolom 'date' ada di migration
                [
                    'scheduled_ok'     => rand(20, 60),
                    'done_on_schedule' => rand(10, 50),
                    'not_on_target'    => rand(5, 40),
                    'notes'            => ['seed' => true],
                ]
            );
        }
    }
}
