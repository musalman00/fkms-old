<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Complaint;
use App\Models\KioskParticipant;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class KioskParticipantComplaintsTest extends TestCase
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
    public function it_gets_kiosk_participant_complaints(): void
    {
        $kioskParticipant = KioskParticipant::factory()->create();
        $complaints = Complaint::factory()
            ->count(2)
            ->create([
                'kiosk_participant_id' => $kioskParticipant->id,
            ]);

        $response = $this->getJson(
            route('api.kiosk-participants.complaints.index', $kioskParticipant)
        );

        $response->assertOk()->assertSee($complaints[0]->title);
    }

    /**
     * @test
     */
    public function it_stores_the_kiosk_participant_complaints(): void
    {
        $kioskParticipant = KioskParticipant::factory()->create();
        $data = Complaint::factory()
            ->make([
                'kiosk_participant_id' => $kioskParticipant->id,
            ])
            ->toArray();

        $response = $this->postJson(
            route('api.kiosk-participants.complaints.store', $kioskParticipant),
            $data
        );

        $this->assertDatabaseHas('complaints', $data);

        $response->assertStatus(201)->assertJsonFragment($data);

        $complaint = Complaint::latest('id')->first();

        $this->assertEquals(
            $kioskParticipant->id,
            $complaint->kiosk_participant_id
        );
    }
}
