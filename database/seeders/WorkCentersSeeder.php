<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\WorkCenter;

class WorkCentersSeeder extends Seeder
{
    public function run(): void
    {
        WorkCenter::updateOrCreate(['slug' => 'kanwil'], ['name'=>'Loket Kanwil','color'=>'#0ea5e9']);
        WorkCenter::updateOrCreate(['slug' => 'dumai'],  ['name'=>'Loket Dumai','color'=>'#22c55e']);
    }
}
