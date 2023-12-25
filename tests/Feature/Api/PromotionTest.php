<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Promotion;

use App\Models\KioskParticipant;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PromotionTest extends TestCase
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
    public function it_gets_promotions_list(): void
    {
        $promotions = Promotion::factory()
            ->count(5)
            ->create();

        $response = $this->getJson(route('api.promotions.index'));

        $response->assertOk()->assertSee($promotions[0]->picture);
    }

    /**
     * @test
     */
    public function it_stores_the_promotion(): void
    {
        $data = Promotion::factory()
            ->make()
            ->toArray();

        $response = $this->postJson(route('api.promotions.store'), $data);

        $this->assertDatabaseHas('promotions', $data);

        $response->assertStatus(201)->assertJsonFragment($data);
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
            'status' => 'Approve',
            'kiosk_participant_id' => $kioskParticipant->id,
        ];

        $response = $this->putJson(
            route('api.promotions.update', $promotion),
            $data
        );

        $data['id'] = $promotion->id;

        $this->assertDatabaseHas('promotions', $data);

        $response->assertOk()->assertJsonFragment($data);
    }

    /**
     * @test
     */
    public function it_deletes_the_promotion(): void
    {
        $promotion = Promotion::factory()->create();

        $response = $this->deleteJson(
            route('api.promotions.destroy', $promotion)
        );

        $this->assertModelMissing($promotion);

        $response->assertNoContent();
    }
}
