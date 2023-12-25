<?php

namespace Database\Factories;

use App\Models\Application;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

class ApplicationFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Application::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'start_date' => $this->faker->date(),
            'end_date' => $this->faker->date(),
            'operating_day' => $this->faker->text(255),
            'operating_hour' => $this->faker->text(255),
            'business_type' => $this->faker->text(255),
            'status' => 'pending',
            'reason_reject' => $this->faker->text(255),
            'kiosk_id' => \App\Models\Kiosk::factory(),
            'user_id' => \App\Models\User::factory(),
            'payment_id' => \App\Models\Payment::factory(),
        ];
    }
}
