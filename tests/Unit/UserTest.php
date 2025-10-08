<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_create_a_user()
    {
        $user = User::factory()->create([
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'is_active' => true,
        ]);

        $this->assertInstanceOf(User::class, $user);
        $this->assertEquals('John Doe', $user->name);
        $this->assertEquals('john@example.com', $user->email);
        $this->assertTrue($user->is_active);
    }

    /** @test */
    public function it_can_assign_roles_to_user()
    {
        $user = User::factory()->create();
        $role = Role::create(['name' => 'test-editor-' . uniqid()]);

        $user->assignRole($role);

        $this->assertTrue($user->hasRole($role->name));
        $this->assertTrue($user->hasRole($role));
    }

    /** @test */
    public function it_can_check_user_permissions()
    {
        $user = User::factory()->create();
        $role = Role::create(['name' => 'test-moderator-' . uniqid()]);
        $permission = Permission::create(['name' => 'test-manage-posts-' . uniqid()]);

        $role->givePermissionTo($permission);
        $user->assignRole($role);

        $this->assertTrue($user->hasPermissionTo($permission->name));
        $this->assertTrue($user->can($permission->name));
    }

    /** @test */
    public function it_can_sync_user_roles()
    {
        $user = User::factory()->create();
        $role1 = Role::create(['name' => 'test-admin-' . uniqid()]);
        $role2 = Role::create(['name' => 'test-user-' . uniqid()]);
        $role3 = Role::create(['name' => 'test-editor-' . uniqid()]);

        // Assign multiple roles
        $user->assignRole([$role1, $role2]);

        $this->assertTrue($user->hasRole($role1->name));
        $this->assertTrue($user->hasRole($role2->name));
        $this->assertFalse($user->hasRole($role3->name));

        // Sync roles (replace existing)
        $user->syncRoles([$role2, $role3]);

        $this->assertFalse($user->hasRole($role1->name));
        $this->assertTrue($user->hasRole($role2->name));
        $this->assertTrue($user->hasRole($role3->name));
    }

    /** @test */
    public function it_can_check_if_user_is_active()
    {
        $activeUser = User::factory()->create(['is_active' => true]);
        $inactiveUser = User::factory()->create(['is_active' => false]);

        $this->assertTrue($activeUser->isActive());
        $this->assertFalse($inactiveUser->isActive());
    }

    /** @test */
    public function it_can_activate_a_user()
    {
        $user = User::factory()->create(['is_active' => false]);

        $this->assertFalse($user->isActive());

        $result = $user->activate();

        $this->assertTrue($result);
        $this->assertTrue($user->fresh()->isActive());
    }

    /** @test */
    public function it_can_deactivate_a_user()
    {
        $user = User::factory()->create(['is_active' => true]);

        $this->assertTrue($user->isActive());

        $result = $user->deactivate();

        $this->assertTrue($result);
        $this->assertFalse($user->fresh()->isActive());
    }

    /** @test */
    public function it_can_toggle_user_active_status()
    {
        $user = User::factory()->create(['is_active' => true]);

        $this->assertTrue($user->isActive());

        $result = $user->toggleActive();

        $this->assertTrue($result);
        $this->assertFalse($user->fresh()->isActive());

        // Toggle again
        $result = $user->fresh()->toggleActive();

        $this->assertTrue($result);
        $this->assertTrue($user->fresh()->isActive());
    }

    /** @test */
    public function it_can_scope_active_users()
    {
        User::factory()->create(['is_active' => true]);
        User::factory()->create(['is_active' => false]);
        User::factory()->create(['is_active' => true]);

        $activeUsers = User::active()->get();
        $inactiveUsers = User::inactive()->get();

        $this->assertCount(2, $activeUsers);
        $this->assertCount(1, $inactiveUsers);

        foreach ($activeUsers as $user) {
            $this->assertTrue($user->is_active);
        }

        foreach ($inactiveUsers as $user) {
            $this->assertFalse($user->is_active);
        }
    }

    /** @test */
    public function it_casts_is_active_to_boolean()
    {
        $user = User::factory()->create(['is_active' => 1]);

        $this->assertIsBool($user->is_active);
        $this->assertTrue($user->is_active);
    }

    /** @test */
    public function it_has_fillable_attributes()
    {
        $user = new User();
        $fillable = $user->getFillable();

        $this->assertContains('name', $fillable);
        $this->assertContains('email', $fillable);
        $this->assertContains('password', $fillable);
        $this->assertContains('is_active', $fillable);
    }

    /** @test */
    public function it_can_have_multiple_roles()
    {
        $user = User::factory()->create();
        $adminRole = Role::create(['name' => 'test-admin-' . uniqid()]);
        $editorRole = Role::create(['name' => 'test-editor-' . uniqid()]);

        $user->assignRole([$adminRole, $editorRole]);

        $this->assertTrue($user->hasRole($adminRole->name));
        $this->assertTrue($user->hasRole($editorRole->name));
        $this->assertCount(2, $user->roles);
    }

    /** @test */
    public function it_can_remove_roles()
    {
        $user = User::factory()->create();
        $role = Role::create(['name' => 'test-admin-' . uniqid()]);

        $user->assignRole($role);
        $this->assertTrue($user->hasRole($role->name));

        $user->removeRole($role);
        $this->assertFalse($user->hasRole($role->name));
    }

    /** @test */
    public function it_can_get_all_permissions_through_roles()
    {
        $user = User::factory()->create();
        $role = Role::create(['name' => 'test-admin-' . uniqid()]);

        $permission1 = Permission::create(['name' => 'test-manage-users-' . uniqid()]);
        $permission2 = Permission::create(['name' => 'test-manage-posts-' . uniqid()]);

        $role->givePermissionTo([$permission1, $permission2]);
        $user->assignRole($role);

        $permissions = $user->getAllPermissions();

        $this->assertCount(2, $permissions);
        $this->assertTrue($permissions->contains('name', $permission1->name));
        $this->assertTrue($permissions->contains('name', $permission2->name));
    }
}