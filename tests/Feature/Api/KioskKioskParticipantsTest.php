<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Kiosk;
use App\Models\KioskParticipant;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class KioskKioskParticipantsTest extends TestCase
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
    public function it_gets_kiosk_kiosk_participants(): void
    {
        $kiosk = Kiosk::factory()->create();
        $kioskParticipants = KioskParticipant::factory()
            ->count(2)
            ->create([
                'kiosk_id' => $kiosk->id,
            ]);

        $response = $this->getJson(
            route('api.kiosks.kiosk-participants.index', $kiosk)
        );

        $response->assertOk()->assertSee($kioskParticipants[0]->id);
    }

    /**
     * @test
     */
    public function it_stores_the_kiosk_kiosk_participants(): void
    {
        $kiosk = Kiosk::factory()->create();
        $data = KioskParticipant::factory()
            ->make([
                'kiosk_id' => $kiosk->id,
            ])
            ->toArray();

        $response = $this->postJson(
            route('api.kiosks.kiosk-participants.store', $kiosk),
            $data
        );

        $this->assertDatabaseHas('kiosk_participants', $data);

        $response->assertStatus(201)->assertJsonFragment($data);

        $kioskParticipant = KioskParticipant::latest('id')->first();

        $this->assertEquals($kiosk->id, $kioskParticipant->kiosk_id);
    }
}
