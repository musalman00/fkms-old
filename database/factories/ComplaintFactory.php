<?php

namespace Database\Factories;

use App\Models\Complaint;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

class ComplaintFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Complaint::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => $this->faker->text(255),
            'category' => $this->faker->text(255),
            'description' => $this->faker->text(255),
            'attachment' => $this->faker->text(),
            'technician_assign' => $this->faker->text(255),
            'reply' => $this->faker->text(),
            'status' => 'Pending',
            'kiosk_participant_id' => \App\Models\KioskParticipant::factory(),
        ];
    }
}
