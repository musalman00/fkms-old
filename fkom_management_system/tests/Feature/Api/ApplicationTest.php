<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Application;

use App\Models\Kiosk;
use App\Models\Payment;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ApplicationTest extends TestCase
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
    public function it_gets_applications_list(): void
    {
        $applications = Application::factory()
            ->count(5)
            ->create();

        $response = $this->getJson(route('api.applications.index'));

        $response->assertOk()->assertSee($applications[0]->start_date);
    }

    /**
     * @test
     */
    public function it_stores_the_application(): void
    {
        $data = Application::factory()
            ->make()
            ->toArray();

        $response = $this->postJson(route('api.applications.store'), $data);

        $this->assertDatabaseHas('applications', $data);

        $response->assertStatus(201)->assertJsonFragment($data);
    }

    /**
     * @test
     */
    public function it_updates_the_application(): void
    {
        $application = Application::factory()->create();

        $kiosk = Kiosk::factory()->create();
        $user = User::factory()->create();
        $payment = Payment::factory()->create();

        $data = [
            'start_date' => $this->faker->date(),
            'end_date' => $this->faker->date(),
            'operating_day' => 'MONDAY',
            'operating_hour' => $this->faker->time(),
            'business_type' => $this->faker->text(255),
            'status' => 'Approve',
            'reason_reject' => $this->faker->text(255),
            'kiosk_id' => $kiosk->id,
            'user_id' => $user->id,
            'payment_id' => $payment->id,
        ];

        $response = $this->putJson(
            route('api.applications.update', $application),
            $data
        );

        $data['id'] = $application->id;

        $this->assertDatabaseHas('applications', $data);

        $response->assertOk()->assertJsonFragment($data);
    }

    /**
     * @test
     */
    public function it_deletes_the_application(): void
    {
        $application = Application::factory()->create();

        $response = $this->deleteJson(
            route('api.applications.destroy', $application)
        );

        $this->assertModelMissing($application);

        $response->assertNoContent();
    }
}
