<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AclTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_create_roles()
    {
        $role = Role::create(['name' => 'test-role-' . uniqid()]);

        $this->assertInstanceOf(Role::class, $role);
        $this->assertNotEmpty($role->name);
    }

    /** @test */
    public function it_can_create_permissions()
    {
        $permission = Permission::create(['name' => 'test-permission-' . uniqid()]);

        $this->assertInstanceOf(Permission::class, $permission);
        $this->assertNotEmpty($permission->name);
    }

    /** @test */
    public function it_can_assign_permissions_to_roles()
    {
        $role = Role::create(['name' => 'test-role-' . uniqid()]);
        $permission = Permission::create(['name' => 'test-permission-' . uniqid()]);

        $role->givePermissionTo($permission);

        $this->assertTrue($role->hasPermissionTo($permission->name));
        $this->assertCount(1, $role->permissions);
    }

    /** @test */
    public function it_can_assign_roles_to_users()
    {
        $user = User::factory()->create();
        $role = Role::create(['name' => 'test-role-' . uniqid()]);

        $user->assignRole($role);

        $this->assertTrue($user->hasRole($role->name));
        $this->assertTrue($user->hasRole($role));
        $this->assertCount(1, $user->roles);
    }

    /** @test */
    public function it_can_check_user_permissions_through_roles()
    {
        $user = User::factory()->create();
        $role = Role::create(['name' => 'test-role-' . uniqid()]);
        $permission = Permission::create(['name' => 'test-permission-' . uniqid()]);

        $role->givePermissionTo($permission);
        $user->assignRole($role);

        $this->assertTrue($user->hasPermissionTo($permission->name));
        $this->assertTrue($user->can($permission->name));
    }

    /** @test */
    public function it_can_check_user_permissions_directly()
    {
        $user = User::factory()->create();
        $permission = Permission::create(['name' => 'test-permission-' . uniqid()]);

        $user->givePermissionTo($permission);

        $this->assertTrue($user->hasPermissionTo($permission->name));
        $this->assertTrue($user->can($permission->name));
    }

    /** @test */
    public function it_can_remove_permissions_from_roles()
    {
        $role = Role::create(['name' => 'test-role-' . uniqid()]);
        $permission = Permission::create(['name' => 'test-permission-' . uniqid()]);

        $role->givePermissionTo($permission);
        $this->assertTrue($role->hasPermissionTo($permission->name));

        $role->revokePermissionTo($permission);
        $this->assertFalse($role->hasPermissionTo($permission->name));
    }

    /** @test */
    public function it_can_remove_roles_from_users()
    {
        $user = User::factory()->create();
        $role = Role::create(['name' => 'test-role-' . uniqid()]);

        $user->assignRole($role);
        $this->assertTrue($user->hasRole($role->name));

        $user->removeRole($role);
        $this->assertFalse($user->hasRole($role->name));
    }

    /** @test */
    public function it_can_get_all_permissions_for_user()
    {
        $user = User::factory()->create();
        $role = Role::create(['name' => 'test-role-' . uniqid()]);

        $permission1 = Permission::create(['name' => 'test-permission-1-' . uniqid()]);
        $permission2 = Permission::create(['name' => 'test-permission-2-' . uniqid()]);
        $permission3 = Permission::create(['name' => 'test-permission-3-' . uniqid()]);

        $role->givePermissionTo([$permission1, $permission2]);
        $user->givePermissionTo($permission3);
        $user->assignRole($role);

        $allPermissions = $user->getAllPermissions();

        $this->assertCount(3, $allPermissions);
        $this->assertTrue($allPermissions->contains('name', $permission1->name));
        $this->assertTrue($allPermissions->contains('name', $permission2->name));
        $this->assertTrue($allPermissions->contains('name', $permission3->name));
    }

    /** @test */
    public function it_can_check_if_user_has_any_of_given_roles()
    {
        $user = User::factory()->create();
        $role1 = Role::create(['name' => 'test-role-1-' . uniqid()]);
        $role2 = Role::create(['name' => 'test-role-2-' . uniqid()]);

        $user->assignRole($role1);

        $this->assertTrue($user->hasAnyRole([$role1->name, $role2->name]));
        $this->assertTrue($user->hasAnyRole([$role1->name]));
        $this->assertFalse($user->hasAnyRole([$role2->name]));
    }

    /** @test */
    public function it_can_check_if_user_has_any_of_given_permissions()
    {
        $user = User::factory()->create();
        $permission1 = Permission::create(['name' => 'test-permission-1-' . uniqid()]);
        $permission2 = Permission::create(['name' => 'test-permission-2-' . uniqid()]);

        $user->givePermissionTo($permission1);

        $this->assertTrue($user->hasAnyPermission([$permission1->name, $permission2->name]));
        $this->assertTrue($user->hasAnyPermission([$permission1->name]));
        $this->assertFalse($user->hasAnyPermission([$permission2->name]));
    }

    /** @test */
    public function it_can_scope_users_by_role()
    {
        $user1 = User::factory()->create();
        $user2 = User::factory()->create();
        $user3 = User::factory()->create();

        $role = Role::create(['name' => 'test-role-' . uniqid()]);

        $user1->assignRole($role);
        $user2->assignRole($role);

        $usersWithRole = User::role($role->name)->get();

        $this->assertCount(2, $usersWithRole);
        $this->assertTrue($usersWithRole->contains('id', $user1->id));
        $this->assertTrue($usersWithRole->contains('id', $user2->id));
        $this->assertFalse($usersWithRole->contains('id', $user3->id));
    }

    /** @test */
    public function it_can_scope_users_by_permission()
    {
        $user1 = User::factory()->create();
        $user2 = User::factory()->create();
        $user3 = User::factory()->create();

        $permission = Permission::create(['name' => 'test-permission-' . uniqid()]);

        $user1->givePermissionTo($permission);
        $user2->givePermissionTo($permission);

        $usersWithPermission = User::permission($permission->name)->get();

        $this->assertCount(2, $usersWithPermission);
        $this->assertTrue($usersWithPermission->contains('id', $user1->id));
        $this->assertTrue($usersWithPermission->contains('id', $user2->id));
        $this->assertFalse($usersWithPermission->contains('id', $user3->id));
    }
}