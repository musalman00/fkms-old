<?php

namespace Database\Factories;

use App\Models\Promotion;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

class PromotionFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Promotion::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'picture' => $this->faker->text(),
            'description' => $this->faker->text(255),
            'publish_time' => $this->faker->dateTime(),
            'promotion_ends' => $this->faker->dateTime(),
            'status' => 'pending',
            'kiosk_participant_id' => \App\Models\KioskParticipant::factory(),
        ];
    }
}
