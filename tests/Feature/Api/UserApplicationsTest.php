<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Application;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserApplicationsTest extends TestCase
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
    public function it_gets_user_applications(): void
    {
        $user = User::factory()->create();
        $applications = Application::factory()
            ->count(2)
            ->create([
                'user_id' => $user->id,
            ]);

        $response = $this->getJson(
            route('api.users.applications.index', $user)
        );

        $response->assertOk()->assertSee($applications[0]->start_date);
    }

    /**
     * @test
     */
    public function it_stores_the_user_applications(): void
    {
        $user = User::factory()->create();
        $data = Application::factory()
            ->make([
                'user_id' => $user->id,
            ])
            ->toArray();

        $response = $this->postJson(
            route('api.users.applications.store', $user),
            $data
        );

        $this->assertDatabaseHas('applications', $data);

        $response->assertStatus(201)->assertJsonFragment($data);

        $application = Application::latest('id')->first();

        $this->assertEquals($user->id, $application->user_id);
    }
}
