<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\KioskParticipant;

use App\Models\Kiosk;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class KioskParticipantTest extends TestCase
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
    public function it_gets_kiosk_participants_list(): void
    {
        $kioskParticipants = KioskParticipant::factory()
            ->count(5)
            ->create();

        $response = $this->getJson(route('api.kiosk-participants.index'));

        $response->assertOk()->assertSee($kioskParticipants[0]->id);
    }

    /**
     * @test
     */
    public function it_stores_the_kiosk_participant(): void
    {
        $data = KioskParticipant::factory()
            ->make()
            ->toArray();

        $response = $this->postJson(
            route('api.kiosk-participants.store'),
            $data
        );

        $this->assertDatabaseHas('kiosk_participants', $data);

        $response->assertStatus(201)->assertJsonFragment($data);
    }

    /**
     * @test
     */
    public function it_updates_the_kiosk_participant(): void
    {
        $kioskParticipant = KioskParticipant::factory()->create();

        $user = User::factory()->create();
        $kiosk = Kiosk::factory()->create();

        $data = [
            'user_id' => $user->id,
            'kiosk_id' => $kiosk->id,
        ];

        $response = $this->putJson(
            route('api.kiosk-participants.update', $kioskParticipant),
            $data
        );

        $data['id'] = $kioskParticipant->id;

        $this->assertDatabaseHas('kiosk_participants', $data);

        $response->assertOk()->assertJsonFragment($data);
    }

    /**
     * @test
     */
    public function it_deletes_the_kiosk_participant(): void
    {
        $kioskParticipant = KioskParticipant::factory()->create();

        $response = $this->deleteJson(
            route('api.kiosk-participants.destroy', $kioskParticipant)
        );

        $this->assertModelMissing($kioskParticipant);

        $response->assertNoContent();
    }
}
