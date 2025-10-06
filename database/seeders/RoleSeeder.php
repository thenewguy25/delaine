<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->command->info('🚀 Setting up roles and permissions...');

        // Create permissions
        $permissions = [
            'manage users',
            'manage roles',
            'manage permissions',
            'moderate content',
            'manage comments',
            'create posts',
            'edit posts',
            'delete posts',
            'view analytics',
            'manage settings',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
            $this->command->info("  ✓ Permission: {$permission}");
        }

        // Create roles with permissions
        $roles = [
            'admin' => [
                'permissions' => ['manage users', 'manage roles', 'manage permissions', 'manage settings'],
                'description' => 'Full system access'
            ],
            'moderator' => [
                'permissions' => ['moderate content', 'manage comments'],
                'description' => 'Content moderation access'
            ],
            'editor' => [
                'permissions' => ['create posts', 'edit posts', 'delete posts'],
                'description' => 'Content creation and editing'
            ],
            'analyst' => [
                'permissions' => ['view analytics'],
                'description' => 'Analytics and reporting access'
            ],
            'user' => [
                'permissions' => [],
                'description' => 'Basic user access'
            ],
        ];

        foreach ($roles as $roleName => $roleData) {
            $role = Role::firstOrCreate(['name' => $roleName]);
            $role->syncPermissions($roleData['permissions']);

            $this->command->info("  ✓ Role: {$roleName} ({$roleData['description']})");
            if (!empty($roleData['permissions'])) {
                $this->command->info("    → Permissions: " . implode(', ', $roleData['permissions']));
            }
        }

        $this->command->newLine();
        $this->command->info('✅ Roles and permissions setup complete!');
        $this->command->info('💡 You can now assign roles to users using:');
        $this->command->info('   php artisan tinker');
        $this->command->info('   User::find(1)->assignRole("moderator");');
    }
}
