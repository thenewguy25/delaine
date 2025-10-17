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
            // Admin permissions
            'manage users',
            'manage roles',
            'manage permissions',
            'manage settings',
            // Content permissions
            'moderate content',
            'manage comments',
            'create posts',
            'edit posts',
            'delete posts',
            'view analytics',
            // Shared permissions (accessible by multiple roles)
            'access dashboard',
            'manage profile',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
            $this->command->info("  ✓ Permission: {$permission}");
        }

        // Create roles with permissions
        $roles = [
            'admin' => [
                'permissions' => [
                    'manage users',
                    'manage roles',
                    'manage permissions',
                    'manage settings',
                    'access dashboard',
                    'manage profile'  // Shared permissions
                ],
                'description' => 'Full system access with all permissions'
            ],
            'moderator' => [
                'permissions' => ['moderate content', 'manage comments', 'access dashboard', 'manage profile'],
                'description' => 'Content moderation access'
            ],
            'editor' => [
                'permissions' => ['create posts', 'edit posts', 'delete posts', 'access dashboard', 'manage profile'],
                'description' => 'Content creation and editing'
            ],
            'analyst' => [
                'permissions' => ['view analytics', 'access dashboard', 'manage profile'],
                'description' => 'Analytics and reporting access'
            ],
            'user' => [
                'permissions' => ['access dashboard', 'manage profile'],
                'description' => 'Basic user access with dashboard and profile management'
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
