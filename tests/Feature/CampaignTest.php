<?php

namespace Tests\Feature;

use App\Models\Campaign;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\UploadedFile;

class CampaignTest extends TestCase
{
    public function test_validator()
    {
        
        $number_1 = rand(0, 3);
        $number_2 = rand(3, 14);
        $date_from = (Carbon::now())->addDays($number_1);
        $date_to = (Carbon::now())->addDays($number_2);
        $daily_budget = rand(10, 500);
        $total_budget = rand(($daily_budget * 5), ($daily_budget * 20));

        Storage::fake('creatives');

        // Test Date Validation
        $data = [
            'name'         => "Random Name",
            'date_from'    => $date_to,
            'date_to'      => $date_from,
            'total_budget' => $total_budget,
            'daily_budget' => $daily_budget,
            'creatives'    => [
                UploadedFile::fake()->image('avatar.jpg')
            ]
        ];
        $response = $this->postJson('/api/campaigns/create', $data);
        $response->assertStatus(400);
        $response->assertSeeText("The start date cannot be after than the end date");

        // Test Budget Validation
        $data = [
            'name'         => "Random Name",
            'date_from'    => $date_from,
            'date_to'      => $date_to,
            'total_budget' => $daily_budget,
            'daily_budget' => $total_budget,
            'creatives'    => [
                UploadedFile::fake()->image('avatar.jpg')
            ]
        ];
        $response = $this->postJson('/api/campaigns/create', $data);
        $response->assertStatus(400);
        $response->assertSeeText("Daily Budget cannot be greater than total budget");

        // Test Create
        $data = [
            'name'         => "Random Name",
            'date_from'    => $date_from,
            'date_to'      => $date_to,
            'total_budget' => $total_budget,
            'daily_budget' => $daily_budget,
            'creatives'    => [
                UploadedFile::fake()->image('avatar.jpg')
            ]
        ];
        $response = $this->postJson('/api/campaigns/create', $data);
        $response->assertStatus(200);
        $response->assertJsonStructure([
            'success',
            'id'
        ]);

        // Test Edit Validation
        $id = $response->json()['id'];
        $new_name = "New Name";
        $data = [
            'id'           => $id,
            'name'         => $new_name,
            'date_from'    => $date_from,
            'date_to'      => $date_to,
            'total_budget' => $total_budget,
            'daily_budget' => $daily_budget
        ];

        $response = $this->postJson('/api/campaigns/edit', $data);
        $response->assertStatus(200);
        $response->assertJsonStructure([
            'success'
        ]);

        $campaign = Campaign::find($id);

        $this->assertEquals($campaign->name, $new_name);

    }
}
