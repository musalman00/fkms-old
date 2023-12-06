<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Promotion;
use App\Models\KioskParticipant;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class KioskParticipantPromotionsTest extends TestCase
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
    public function it_gets_kiosk_participant_promotions(): void
    {
        $kioskParticipant = KioskParticipant::factory()->create();
        $promotions = Promotion::factory()
            ->count(2)
            ->create([
                'kiosk_participant_id' => $kioskParticipant->id,
            ]);

        $response = $this->getJson(
            route('api.kiosk-participants.promotions.index', $kioskParticipant)
        );

        $response->assertOk()->assertSee($promotions[0]->picture);
    }

    /**
     * @test
     */
    public function it_stores_the_kiosk_participant_promotions(): void
    {
        $kioskParticipant = KioskParticipant::factory()->create();
        $data = Promotion::factory()
            ->make([
                'kiosk_participant_id' => $kioskParticipant->id,
            ])
            ->toArray();

        $response = $this->postJson(
            route('api.kiosk-participants.promotions.store', $kioskParticipant),
            $data
        );

        $this->assertDatabaseHas('promotions', $data);

        $response->assertStatus(201)->assertJsonFragment($data);

        $promotion = Promotion::latest('id')->first();

        $this->assertEquals(
            $kioskParticipant->id,
            $promotion->kiosk_participant_id
        );
    }
}
