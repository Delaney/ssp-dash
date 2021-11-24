<?php

namespace Database\Seeders;

use App\Models\CampaignCreative;
use Illuminate\Database\Seeder;

class CampaignSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $number = rand(3, 10);
        \App\Models\Campaign::factory(5)
            ->has(CampaignCreative::factory()->count($number), 'creatives')
            ->create();;
    }
}
