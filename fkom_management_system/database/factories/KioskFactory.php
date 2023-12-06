<?php

namespace Database\Factories;

use App\Models\Kiosk;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

class KioskFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Kiosk::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'number' => $this->faker->text(255),
            'name' => $this->faker->text(255),
            'description' => $this->faker->text(255),
        ];
    }
}
