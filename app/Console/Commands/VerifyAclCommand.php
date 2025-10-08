<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;

class VerifyAclCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'verify:acl';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Verify ACL setup and permissions for Delaine framework';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $this->info('🔍 Verifying Delaine Framework ACL Setup...');
        $this->newLine();

        // Check middleware registration
        $this->checkMiddleware();

        // Check roles and permissions
        $this->checkRolesAndPermissions();

        // Check admin users
        $this->checkAdminUsers();

        // Check user permissions
        $this->checkUserPermissions();

        $this->newLine();
        $this->info('✅ ACL verification complete!');
        $this->newLine();
        $this->info('💡 Use "php artisan make:admin" to create new admin users');

        return 0;
    }

    private function checkMiddleware()
    {
        $this->info('📋 Checking Middleware Registration:');

        $kernel = app(\App\Http\Kernel::class);
        $routeMiddleware = $kernel->getRouteMiddleware();

        if (isset($routeMiddleware['role'])) {
            $this->line('  ✅ Role middleware registered');
        } else {
            $this->error('  ❌ Role middleware NOT registered');
        }

        if (isset($routeMiddleware['permission'])) {
            $this->line('  ✅ Permission middleware registered');
        } else {
            $this->error('  ❌ Permission middleware NOT registered');
        }

        $this->newLine();
    }

    private function checkRolesAndPermissions()
    {
        $this->info('👥 Checking Roles and Permissions:');

        $roles = Role::all();
        $permissions = Permission::all();

        $this->line("  📊 Found {$roles->count()} roles:");
        foreach ($roles as $role) {
            $permissionCount = $role->permissions()->count();
            $this->line("    - {$role->name} ({$permissionCount} permissions)");
        }

        $this->line("  📊 Found {$permissions->count()} permissions:");
        foreach ($permissions as $permission) {
            $this->line("    - {$permission->name}");
        }

        $this->newLine();
    }

    private function checkAdminUsers()
    {
        $this->info('👑 Checking Admin Users:');

        $adminUsers = User::role('admin')->get();

        if ($adminUsers->count() > 0) {
            $this->line("  ✅ Found {$adminUsers->count()} admin user(s):");
            foreach ($adminUsers as $user) {
                $this->line("    - {$user->name} ({$user->email})");
            }
        } else {
            $this->warn('  ⚠️  No admin users found. Run: php artisan make:admin');
        }

        $this->newLine();
    }

    private function checkUserPermissions()
    {
        $this->info('🔐 Checking User Permissions:');

        $users = User::with('roles')->get();

        foreach ($users as $user) {
            $roles = $user->roles->pluck('name')->toArray();
            $permissions = $user->getAllPermissions()->pluck('name')->toArray();

            $this->line("  👤 {$user->name} ({$user->email}):");
            $this->line("    Roles: " . (empty($roles) ? 'None' : implode(', ', $roles)));
            $this->line("    Permissions: " . (empty($permissions) ? 'None' : implode(', ', $permissions)));
        }

        $this->newLine();
    }
}
