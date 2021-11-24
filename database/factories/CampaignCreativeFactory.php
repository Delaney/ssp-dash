<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class CampaignCreativeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $images = [
            'https://cdn.pixabay.com/photo/2019/04/24/21/55/cinema-4153289_1280.jpg',
            'https://cdn.pixabay.com/photo/2021/11/02/15/30/tealights-6763542_1280.jpg',
            'https://cdn.pixabay.com/photo/2021/11/11/13/08/leopard-6786267_1280.jpg',
            'https://cdn.pixabay.com/photo/2021/10/25/17/16/nature-6741602_1280.jpg',
            'https://cdn.pixabay.com/photo/2021/11/12/06/58/sea-6788169_1280.jpg',
            'https://cdn.pixabay.com/photo/2021/11/20/21/22/nature-6812778_1280.jpg',
        ];

        $index = $this->faker->numberBetween(0, count($images) - 1);

        return [
            'filename'   => $this->faker->text(15),
            'upload_path' => $images[$index],
            'extension'   => 'jpg'
        ];
    }
}
