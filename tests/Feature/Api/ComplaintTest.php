<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Complaint;

use App\Models\KioskParticipant;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ComplaintTest extends TestCase
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
    public function it_gets_complaints_list(): void
    {
        $complaints = Complaint::factory()
            ->count(5)
            ->create();

        $response = $this->getJson(route('api.complaints.index'));

        $response->assertOk()->assertSee($complaints[0]->title);
    }

    /**
     * @test
     */
    public function it_stores_the_complaint(): void
    {
        $data = Complaint::factory()
            ->make()
            ->toArray();

        $response = $this->postJson(route('api.complaints.store'), $data);

        $this->assertDatabaseHas('complaints', $data);

        $response->assertStatus(201)->assertJsonFragment($data);
    }

    /**
     * @test
     */
    public function it_updates_the_complaint(): void
    {
        $complaint = Complaint::factory()->create();

        $kioskParticipant = KioskParticipant::factory()->create();

        $data = [
            'title' => $this->faker->text(255),
            'category' => $this->faker->text(255),
            'description' => $this->faker->text(255),
            'attachment' => $this->faker->text(),
            'technician_assign' => $this->faker->text(255),
            'reply' => $this->faker->text(),
            'status' => 'Pending',
            'kiosk_participant_id' => $kioskParticipant->id,
        ];

        $response = $this->putJson(
            route('api.complaints.update', $complaint),
            $data
        );

        $data['id'] = $complaint->id;

        $this->assertDatabaseHas('complaints', $data);

        $response->assertOk()->assertJsonFragment($data);
    }

    /**
     * @test
     */
    public function it_deletes_the_complaint(): void
    {
        $complaint = Complaint::factory()->create();

        $response = $this->deleteJson(
            route('api.complaints.destroy', $complaint)
        );

        $this->assertModelMissing($complaint);

        $response->assertNoContent();
    }
}
