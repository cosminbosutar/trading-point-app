<?php

namespace Database\Factories;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Stock>
 */
class StockFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'symbol' => 'AAPL',
            'timestamp' => Carbon::now(),
            'open' => fake()->randomFloat(),
            'high' => fake()->randomFloat(),
            'low' => fake()->randomFloat(),
            'close' => fake()->randomFloat(),
            'volume' => fake()->randomNumber()
        ];
    }
}
