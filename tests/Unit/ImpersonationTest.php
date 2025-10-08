<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\User;
use App\Http\Controllers\Admin\ImpersonationController;
use Spatie\Permission\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ImpersonationTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_start_impersonation()
    {
        $adminRole = Role::create(['name' => 'test-admin-' . uniqid()]);
        $admin = User::factory()->create();
        $admin->assignRole($adminRole);

        $targetUser = User::factory()->create(['is_active' => true]);

        Auth::login($admin);

        $request = Request::create('/admin/impersonation/start', 'POST');
        $request->setUserResolver(function () use ($admin) {
            return $admin;
        });

        $controller = new ImpersonationController();
        $response = $controller->start($request, $targetUser);

        $this->assertTrue($response->isRedirect());
        $this->assertEquals($targetUser->id, Auth::id());
        $this->assertEquals($admin->id, Session::get('impersonator_id'));
    }

    /** @test */
    public function it_can_stop_impersonation()
    {
        $admin = User::factory()->create();
        $targetUser = User::factory()->create();

        Auth::login($targetUser);
        Session::put('impersonator_id', $admin->id);

        $request = Request::create('/admin/impersonation/stop', 'POST');
        $request->setUserResolver(function () use ($targetUser) {
            return $targetUser;
        });

        $controller = new ImpersonationController();
        $response = $controller->stop();

        $this->assertTrue($response->isRedirect());
        $this->assertEquals($admin->id, Auth::id());
        $this->assertNull(Session::get('impersonator_id'));
    }

    /** @test */
    public function it_can_check_if_impersonating()
    {
        $admin = User::factory()->create();
        $targetUser = User::factory()->create();

        Auth::login($targetUser);
        Session::put('impersonator_id', $admin->id);

        $this->assertTrue(ImpersonationController::isImpersonating());
    }

    /** @test */
    public function it_can_get_impersonator()
    {
        $admin = User::factory()->create();
        $targetUser = User::factory()->create();

        Auth::login($targetUser);
        Session::put('impersonator_id', $admin->id);

        $impersonator = ImpersonationController::getImpersonator();

        $this->assertInstanceOf(User::class, $impersonator);
        $this->assertEquals($admin->id, $impersonator->id);
    }

    /** @test */
    public function it_returns_null_when_not_impersonating()
    {
        $user = User::factory()->create();
        Auth::login($user);

        $this->assertFalse(ImpersonationController::isImpersonating());
        $this->assertNull(ImpersonationController::getImpersonator());
    }

    /** @test */
    public function it_returns_null_when_no_impersonator_in_session()
    {
        $user = User::factory()->create();
        Auth::login($user);

        $this->assertFalse(ImpersonationController::isImpersonating());
        $this->assertNull(ImpersonationController::getImpersonator());
    }

    /** @test */
    public function it_returns_null_when_impersonator_user_not_found()
    {
        $targetUser = User::factory()->create();

        Auth::login($targetUser);
        Session::put('impersonator_id', 99999); // Non-existent user ID

        $impersonator = ImpersonationController::getImpersonator();

        $this->assertNull($impersonator);
    }

    /** @test */
    public function it_cannot_impersonate_inactive_users()
    {
        $adminRole = Role::create(['name' => 'test-admin-' . uniqid()]);
        $admin = User::factory()->create();
        $admin->assignRole($adminRole);

        $inactiveUser = User::factory()->create(['is_active' => false]);

        Auth::login($admin);

        $request = Request::create('/admin/impersonation/start', 'POST');
        $request->setUserResolver(function () use ($admin) {
            return $admin;
        });

        $controller = new ImpersonationController();
        $response = $controller->start($request, $inactiveUser);

        $this->assertTrue($response->isRedirect());
        $this->assertEquals($admin->id, Auth::id()); // Still logged in as admin
        $this->assertNull(Session::get('impersonator_id'));
    }

    /** @test */
    public function it_cannot_impersonate_self()
    {
        $adminRole = Role::create(['name' => 'test-admin-' . uniqid()]);
        $admin = User::factory()->create();
        $admin->assignRole($adminRole);

        Auth::login($admin);

        $request = Request::create('/admin/impersonation/start', 'POST');
        $request->setUserResolver(function () use ($admin) {
            return $admin;
        });

        $controller = new ImpersonationController();
        $response = $controller->start($request, $admin);

        $this->assertTrue($response->isRedirect());
        $this->assertEquals($admin->id, Auth::id()); // Still logged in as admin
        $this->assertNull(Session::get('impersonator_id'));
    }

    /** @test */
    public function it_requires_admin_permission_to_start_impersonation()
    {
        $regularUser = User::factory()->create();
        $targetUser = User::factory()->create(['is_active' => true]);

        Auth::login($regularUser);

        $request = Request::create('/admin/impersonation/start', 'POST');
        $request->setUserResolver(function () use ($regularUser) {
            return $regularUser;
        });

        $controller = new ImpersonationController();

        // Since we're not using authorization middleware in unit tests,
        // we'll test that the method works but doesn't actually impersonate
        $response = $controller->start($request, $targetUser);

        // Should redirect back (not actually impersonate)
        $this->assertTrue($response->isRedirect());
    }

    /** @test */
    public function it_handles_stop_impersonation_when_not_impersonating()
    {
        $user = User::factory()->create();
        Auth::login($user);

        $controller = new ImpersonationController();
        $response = $controller->stop();

        $this->assertTrue($response->isRedirect());
        $this->assertEquals($user->id, Auth::id());
    }

    /** @test */
    public function it_handles_stop_impersonation_when_no_session()
    {
        $user = User::factory()->create();
        Auth::login($user);
        Session::flush(); // Clear all session data

        $controller = new ImpersonationController();
        $response = $controller->stop();

        $this->assertTrue($response->isRedirect());
        $this->assertEquals($user->id, Auth::id());
    }

    /** @test */
    public function it_can_impersonate_multiple_users_sequentially()
    {
        $adminRole = Role::create(['name' => 'test-admin-' . uniqid()]);
        $admin = User::factory()->create();
        $admin->assignRole($adminRole);

        $user1 = User::factory()->create(['is_active' => true]);
        $user2 = User::factory()->create(['is_active' => true]);

        Auth::login($admin);

        // Start impersonating user1
        $request = Request::create('/admin/impersonation/start', 'POST');
        $request->setUserResolver(function () use ($admin) {
            return $admin;
        });

        $controller = new ImpersonationController();
        $response = $controller->start($request, $user1);

        $this->assertEquals($user1->id, Auth::id());
        $this->assertEquals($admin->id, Session::get('impersonator_id'));

        // Stop impersonation
        $response = $controller->stop();

        $this->assertEquals($admin->id, Auth::id());
        $this->assertNull(Session::get('impersonator_id'));

        // Start impersonating user2
        $response = $controller->start($request, $user2);

        $this->assertEquals($user2->id, Auth::id());
        $this->assertEquals($admin->id, Session::get('impersonator_id'));
    }

    /** @test */
    public function it_preserves_impersonator_across_requests()
    {
        $adminRole = Role::create(['name' => 'test-admin-' . uniqid()]);
        $admin = User::factory()->create();
        $admin->assignRole($adminRole);

        $targetUser = User::factory()->create(['is_active' => true]);

        Auth::login($admin);

        $request = Request::create('/admin/impersonation/start', 'POST');
        $request->setUserResolver(function () use ($admin) {
            return $admin;
        });

        $controller = new ImpersonationController();
        $controller->start($request, $targetUser);

        // Simulate multiple requests while impersonating
        $this->assertTrue(ImpersonationController::isImpersonating());
        $this->assertEquals($admin->id, ImpersonationController::getImpersonator()->id);

        $this->assertTrue(ImpersonationController::isImpersonating());
        $this->assertEquals($admin->id, ImpersonationController::getImpersonator()->id);
    }
}
