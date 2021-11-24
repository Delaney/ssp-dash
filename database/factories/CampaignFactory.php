<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Carbon\Carbon;

class CampaignFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $number_1 = $this->faker->numberBetween(0, 3);
        $number_2 = $this->faker->numberBetween(3, 14);
        $date_from = (Carbon::now())->addDays($number_1);
        $date_to = (Carbon::now())->addDays($number_2);
        $daily_budget = $this->faker->randomFloat(2, 10, 500);
        $total_budget = $this->faker->randomFloat(2, ($daily_budget * 5), ($daily_budget * 20));

        return [
            'name'         => $this->faker->text(12),
            'date_from'    => $date_from,
            'date_to'      => $date_to,
            'total_budget' => $total_budget,
            'daily_budget' => $daily_budget,
        ];
    }
}
