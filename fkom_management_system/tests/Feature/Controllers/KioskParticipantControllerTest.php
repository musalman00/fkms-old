<?php

namespace Tests\Feature\Controllers;

use App\Models\User;
use App\Models\KioskParticipant;

use App\Models\Kiosk;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class KioskParticipantControllerTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    protected function setUp(): void
    {
        parent::setUp();

        $this->actingAs(
            User::factory()->create(['email' => 'admin@admin.com'])
        );

        $this->seed(\Database\Seeders\PermissionsSeeder::class);

        $this->withoutExceptionHandling();
    }

    /**
     * @test
     */
    public function it_displays_index_view_with_kiosk_participants(): void
    {
        $kioskParticipants = KioskParticipant::factory()
            ->count(5)
            ->create();

        $response = $this->get(route('kiosk-participants.index'));

        $response
            ->assertOk()
            ->assertViewIs('app.kiosk_participants.index')
            ->assertViewHas('kioskParticipants');
    }

    /**
     * @test
     */
    public function it_displays_create_view_for_kiosk_participant(): void
    {
        $response = $this->get(route('kiosk-participants.create'));

        $response->assertOk()->assertViewIs('app.kiosk_participants.create');
    }

    /**
     * @test
     */
    public function it_stores_the_kiosk_participant(): void
    {
        $data = KioskParticipant::factory()
            ->make()
            ->toArray();

        $response = $this->post(route('kiosk-participants.store'), $data);

        $this->assertDatabaseHas('kiosk_participants', $data);

        $kioskParticipant = KioskParticipant::latest('id')->first();

        $response->assertRedirect(
            route('kiosk-participants.edit', $kioskParticipant)
        );
    }

    /**
     * @test
     */
    public function it_displays_show_view_for_kiosk_participant(): void
    {
        $kioskParticipant = KioskParticipant::factory()->create();

        $response = $this->get(
            route('kiosk-participants.show', $kioskParticipant)
        );

        $response
            ->assertOk()
            ->assertViewIs('app.kiosk_participants.show')
            ->assertViewHas('kioskParticipant');
    }

    /**
     * @test
     */
    public function it_displays_edit_view_for_kiosk_participant(): void
    {
        $kioskParticipant = KioskParticipant::factory()->create();

        $response = $this->get(
            route('kiosk-participants.edit', $kioskParticipant)
        );

        $response
            ->assertOk()
            ->assertViewIs('app.kiosk_participants.edit')
            ->assertViewHas('kioskParticipant');
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

        $response = $this->put(
            route('kiosk-participants.update', $kioskParticipant),
            $data
        );

        $data['id'] = $kioskParticipant->id;

        $this->assertDatabaseHas('kiosk_participants', $data);

        $response->assertRedirect(
            route('kiosk-participants.edit', $kioskParticipant)
        );
    }

    /**
     * @test
     */
    public function it_deletes_the_kiosk_participant(): void
    {
        $kioskParticipant = KioskParticipant::factory()->create();

        $response = $this->delete(
            route('kiosk-participants.destroy', $kioskParticipant)
        );

        $response->assertRedirect(route('kiosk-participants.index'));

        $this->assertSoftDeleted($kioskParticipant);
    }
}
