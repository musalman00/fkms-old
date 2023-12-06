<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\KioskParticipant;

class KioskParticipantSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        KioskParticipant::factory()
            ->count(5)
            ->create();
    }
}
