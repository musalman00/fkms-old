<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Kiosk;
use App\Models\Application;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class KioskApplicationsTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    protected function setUp(): void
    {
        parent::setUp();

        $user = User::factory()->create(['email' => 'admin@admin.com']);

        Sanctum::actingAs($user, [], 'web');

        $this->seed(\Database\Seeders\PermissionsSeeder::class);

        $this->withoutExceptionHandling();
    }

    /**
     * @test
     */
    public function it_gets_kiosk_applications(): void
    {
        $kiosk = Kiosk::factory()->create();
        $applications = Application::factory()
            ->count(2)
            ->create([
                'kiosk_id' => $kiosk->id,
            ]);

        $response = $this->getJson(
            route('api.kiosks.applications.index', $kiosk)
        );

        $response->assertOk()->assertSee($applications[0]->start_date);
    }

    /**
     * @test
     */
    public function it_stores_the_kiosk_applications(): void
    {
        $kiosk = Kiosk::factory()->create();
        $data = Application::factory()
            ->make([
                'kiosk_id' => $kiosk->id,
            ])
            ->toArray();

        $response = $this->postJson(
            route('api.kiosks.applications.store', $kiosk),
            $data
        );

        $this->assertDatabaseHas('applications', $data);

        $response->assertStatus(201)->assertJsonFragment($data);

        $application = Application::latest('id')->first();

        $this->assertEquals($kiosk->id, $application->kiosk_id);
    }
}
