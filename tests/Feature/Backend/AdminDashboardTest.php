<?php

namespace Tests\Feature\Backend;

use Tests\TestCase;
use App\Models\Auth\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

/**
 * Class DashboardRouteTest.
 */
class AdminDashboardTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function unauthenticated_users_cant_access_admin_dashboard()
    {
        $this->get('/admin/dashboard')->assertRedirect('/login');
    }

    /** @test */
    public function not_authorized_users_cant_access_admin_dashboard()
    {
        $this->actingAs(factory(User::class)->create());

        $response = $this->get('/admin/dashboard');

        $response->assertRedirect('/dashboard');
    }

    /** @test */
    public function admin_can_access_admin_dashboard()
    {
        $this->loginAsAdmin();

        $request = $this->get('/admin/dashboard');

        $request->assertStatus(200);
    }

    public function coach_can_access_admin_dashboard()
    {
        $this->loginAsCoach();

        $this->get('/admin/dashboard')->assertStatus(200);
    }

    public function box_admin_can_access_admin_dashboard()
    {
        $this->loginAsBoxAdmin();

        $this->get('/admin/dashboard')->assertStatus(200);
    }
}
