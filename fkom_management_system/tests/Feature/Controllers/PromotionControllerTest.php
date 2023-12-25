<?php

namespace Tests\Feature\Controllers;

use App\Models\User;
use App\Models\Promotion;

use App\Models\KioskParticipant;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PromotionControllerTest extends TestCase
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
    public function it_displays_index_view_with_promotions(): void
    {
        $promotions = Promotion::factory()
            ->count(5)
            ->create();

        $response = $this->get(route('promotions.index'));

        $response
            ->assertOk()
            ->assertViewIs('app.promotions.index')
            ->assertViewHas('promotions');
    }

    /**
     * @test
     */
    public function it_displays_create_view_for_promotion(): void
    {
        $response = $this->get(route('promotions.create'));

        $response->assertOk()->assertViewIs('app.promotions.create');
    }

    /**
     * @test
     */
    public function it_stores_the_promotion(): void
    {
        $data = Promotion::factory()
            ->make()
            ->toArray();

        $response = $this->post(route('promotions.store'), $data);

        unset($data['picture']);

        $this->assertDatabaseHas('promotions', $data);

        $promotion = Promotion::latest('id')->first();

        $response->assertRedirect(route('promotions.edit', $promotion));
    }

    /**
     * @test
     */
    public function it_displays_show_view_for_promotion(): void
    {
        $promotion = Promotion::factory()->create();

        $response = $this->get(route('promotions.show', $promotion));

        $response
            ->assertOk()
            ->assertViewIs('app.promotions.show')
            ->assertViewHas('promotion');
    }

    /**
     * @test
     */
    public function it_displays_edit_view_for_promotion(): void
    {
        $promotion = Promotion::factory()->create();

        $response = $this->get(route('promotions.edit', $promotion));

        $response
            ->assertOk()
            ->assertViewIs('app.promotions.edit')
            ->assertViewHas('promotion');
    }

    /**
     * @test
     */
    public function it_updates_the_promotion(): void
    {
        $promotion = Promotion::factory()->create();

        $kioskParticipant = KioskParticipant::factory()->create();

        $data = [
            'picture' => $this->faker->text(),
            'description' => $this->faker->text(255),
            'publish_time' => $this->faker->dateTime(),
            'promotion_ends' => $this->faker->dateTime(),
            'status' => 'pending',
            'kiosk_participant_id' => $kioskParticipant->id,
        ];

        $response = $this->put(route('promotions.update', $promotion), $data);

        unset($data['picture']);

        $data['id'] = $promotion->id;

        $this->assertDatabaseHas('promotions', $data);

        $response->assertRedirect(route('promotions.edit', $promotion));
    }

    /**
     * @test
     */
    public function it_deletes_the_promotion(): void
    {
        $promotion = Promotion::factory()->create();

        $response = $this->delete(route('promotions.destroy', $promotion));

        $response->assertRedirect(route('promotions.index'));

        $this->assertSoftDeleted($promotion);
    }
}
