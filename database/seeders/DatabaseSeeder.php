<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Showcase;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // ─── Users ────────────────────────────────────────────────────────────

        $admin = User::create([
            'name'     => 'Administrator',
            'email'    => 'admin@mail.com',
            'password' => Hash::make('password'),
            'role'     => 'admin',
        ]);

        $coffee = User::create([
            'name'     => 'Coffee Client',
            'email'    => 'coffee@mail.com',
            'password' => Hash::make('password'),
            'role'     => 'coffee',
        ]);

        $chocolate = User::create([
            'name'     => 'Chocolate Client',
            'email'    => 'choco@mail.com',
            'password' => Hash::make('password'),
            'role'     => 'chocolate',
        ]);

        // ─── Showcases for Coffee ─────────────────────────────────────────────

        Showcase::create([
            'serial_number'      => 'HC-2026-001',
            'user_id'            => $coffee->id,
            'warranty_expired_at'=> now()->addYears(2)->toDateString(), // Aktif
            'compressor_type'    => 'Embraco Inverter',
            'glass_spec'         => 'Double Glass Anti-Fog',
        ]);

        Showcase::create([
            'serial_number'      => 'HC-2026-002',
            'user_id'            => $coffee->id,
            'warranty_expired_at'=> now()->subMonths(3)->toDateString(), // Kedaluwarsa
            'compressor_type'    => 'Danfoss Scroll',
            'glass_spec'         => 'Triple Glass Low-E Coating',
        ]);

        // ─── Showcases for Chocolate ──────────────────────────────────────────

        Showcase::create([
            'serial_number'      => 'HC-2026-003',
            'user_id'            => $chocolate->id,
            'warranty_expired_at'=> now()->addYear()->toDateString(), // Aktif
            'compressor_type'    => 'Tecumseh Rotary',
            'glass_spec'         => 'Single Glass Tempered',
        ]);
    }
}
