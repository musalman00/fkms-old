<?php

namespace Tests\Feature\Controllers;

use App\Models\User;
use App\Models\Application;

use App\Models\Kiosk;
use App\Models\Payment;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ApplicationControllerTest extends TestCase
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
    public function it_displays_index_view_with_applications(): void
    {
        $applications = Application::factory()
            ->count(5)
            ->create();

        $response = $this->get(route('applications.index'));

        $response
            ->assertOk()
            ->assertViewIs('app.applications.index')
            ->assertViewHas('applications');
    }

    /**
     * @test
     */
    public function it_displays_create_view_for_application(): void
    {
        $response = $this->get(route('applications.create'));

        $response->assertOk()->assertViewIs('app.applications.create');
    }

    /**
     * @test
     */
    public function it_stores_the_application(): void
    {
        $data = Application::factory()
            ->make()
            ->toArray();

        $response = $this->post(route('applications.store'), $data);

        $this->assertDatabaseHas('applications', $data);

        $application = Application::latest('id')->first();

        $response->assertRedirect(route('applications.edit', $application));
    }

    /**
     * @test
     */
    public function it_displays_show_view_for_application(): void
    {
        $application = Application::factory()->create();

        $response = $this->get(route('applications.show', $application));

        $response
            ->assertOk()
            ->assertViewIs('app.applications.show')
            ->assertViewHas('application');
    }

    /**
     * @test
     */
    public function it_displays_edit_view_for_application(): void
    {
        $application = Application::factory()->create();

        $response = $this->get(route('applications.edit', $application));

        $response
            ->assertOk()
            ->assertViewIs('app.applications.edit')
            ->assertViewHas('application');
    }

    /**
     * @test
     */
    public function it_updates_the_application(): void
    {
        $application = Application::factory()->create();

        $kiosk = Kiosk::factory()->create();
        $user = User::factory()->create();
        $payment = Payment::factory()->create();

        $data = [
            'start_date' => $this->faker->date(),
            'end_date' => $this->faker->date(),
            'operating_day' => 'MONDAY',
            'operating_hour' => $this->faker->time(),
            'business_type' => $this->faker->text(255),
            'status' => 'Approve',
            'reason_reject' => $this->faker->text(255),
            'kiosk_id' => $kiosk->id,
            'user_id' => $user->id,
            'payment_id' => $payment->id,
        ];

        $response = $this->put(
            route('applications.update', $application),
            $data
        );

        $data['id'] = $application->id;

        $this->assertDatabaseHas('applications', $data);

        $response->assertRedirect(route('applications.edit', $application));
    }

    /**
     * @test
     */
    public function it_deletes_the_application(): void
    {
        $application = Application::factory()->create();

        $response = $this->delete(route('applications.destroy', $application));

        $response->assertRedirect(route('applications.index'));

        $this->assertModelMissing($application);
    }
}
