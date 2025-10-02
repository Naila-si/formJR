<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // ✅ Buat / update tanpa duplikat
        User::updateOrCreate(
            ['email' => 'test@example.com'],
            [
                'name' => 'Test User',
                'password' => Hash::make('password'),   // set password jelas
                'email_verified_at' => now(),
            ]
        );

        // (Opsional) hanya panggil kalau memang ada dan tidak bikin user yang sama
        $this->call(AdminSeeder::class);

        // Seed data RK (pegawai dulu, baru shift)
        $this->call([
            EmployeesTableSeeder::class,
            ShiftsTableSeeder::class,
            DayMetricsSeeder::class,
            WorkCentersSeeder::class,
        ]);
    }
}
