<?php

namespace Database\Factories;

use Illuminate\Support\Str;
use App\Models\KioskParticipant;
use Illuminate\Database\Eloquent\Factories\Factory;

class KioskParticipantFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = KioskParticipant::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => \App\Models\User::factory(),
            'kiosk_id' => \App\Models\Kiosk::factory(),
        ];
    }
}
