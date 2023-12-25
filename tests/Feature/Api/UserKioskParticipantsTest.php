<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\KioskParticipant;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserKioskParticipantsTest extends TestCase
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
    public function it_gets_user_kiosk_participants(): void
    {
        $user = User::factory()->create();
        $kioskParticipants = KioskParticipant::factory()
            ->count(2)
            ->create([
                'user_id' => $user->id,
            ]);

        $response = $this->getJson(
            route('api.users.kiosk-participants.index', $user)
        );

        $response->assertOk()->assertSee($kioskParticipants[0]->id);
    }

    /**
     * @test
     */
    public function it_stores_the_user_kiosk_participants(): void
    {
        $user = User::factory()->create();
        $data = KioskParticipant::factory()
            ->make([
                'user_id' => $user->id,
            ])
            ->toArray();

        $response = $this->postJson(
            route('api.users.kiosk-participants.store', $user),
            $data
        );

        $this->assertDatabaseHas('kiosk_participants', $data);

        $response->assertStatus(201)->assertJsonFragment($data);

        $kioskParticipant = KioskParticipant::latest('id')->first();

        $this->assertEquals($user->id, $kioskParticipant->user_id);
    }
}
