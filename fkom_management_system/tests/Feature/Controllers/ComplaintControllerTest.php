<?php

namespace Tests\Feature\Controllers;

use App\Models\User;
use App\Models\Complaint;

use App\Models\KioskParticipant;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ComplaintControllerTest extends TestCase
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
    public function it_displays_index_view_with_complaints(): void
    {
        $complaints = Complaint::factory()
            ->count(5)
            ->create();

        $response = $this->get(route('complaints.index'));

        $response
            ->assertOk()
            ->assertViewIs('app.complaints.index')
            ->assertViewHas('complaints');
    }

    /**
     * @test
     */
    public function it_displays_create_view_for_complaint(): void
    {
        $response = $this->get(route('complaints.create'));

        $response->assertOk()->assertViewIs('app.complaints.create');
    }

    /**
     * @test
     */
    public function it_stores_the_complaint(): void
    {
        $data = Complaint::factory()
            ->make()
            ->toArray();

        $response = $this->post(route('complaints.store'), $data);

        $this->assertDatabaseHas('complaints', $data);

        $complaint = Complaint::latest('id')->first();

        $response->assertRedirect(route('complaints.edit', $complaint));
    }

    /**
     * @test
     */
    public function it_displays_show_view_for_complaint(): void
    {
        $complaint = Complaint::factory()->create();

        $response = $this->get(route('complaints.show', $complaint));

        $response
            ->assertOk()
            ->assertViewIs('app.complaints.show')
            ->assertViewHas('complaint');
    }

    /**
     * @test
     */
    public function it_displays_edit_view_for_complaint(): void
    {
        $complaint = Complaint::factory()->create();

        $response = $this->get(route('complaints.edit', $complaint));

        $response
            ->assertOk()
            ->assertViewIs('app.complaints.edit')
            ->assertViewHas('complaint');
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
            'status' => 'pending',
            'kiosk_participant_id' => $kioskParticipant->id,
        ];

        $response = $this->put(route('complaints.update', $complaint), $data);

        $data['id'] = $complaint->id;

        $this->assertDatabaseHas('complaints', $data);

        $response->assertRedirect(route('complaints.edit', $complaint));
    }

    /**
     * @test
     */
    public function it_deletes_the_complaint(): void
    {
        $complaint = Complaint::factory()->create();

        $response = $this->delete(route('complaints.destroy', $complaint));

        $response->assertRedirect(route('complaints.index'));

        $this->assertSoftDeleted($complaint);
    }
}
