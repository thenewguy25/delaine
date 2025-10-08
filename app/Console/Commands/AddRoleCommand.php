<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class AddRoleCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'role:add {name} {permissions?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Add a new role with optional permissions';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $roleName = $this->argument('name');
        $permissions = $this->argument('permissions');

        $this->info("🚀 Adding role: {$roleName}");

        // Validate role name
        if (empty($roleName)) {
            $this->error('❌ Role name cannot be empty');
            return 1;
        }

        // Check if role already exists
        if (Role::where('name', $roleName)->exists()) {
            $this->warn("⚠️  Role '{$roleName}' already exists");
            if (!$this->confirm("Do you want to update its permissions?")) {
                $this->info('❌ Operation cancelled');
                return 0;
            }
        }

        try {
            // Create or get the role
            $role = Role::firstOrCreate(['name' => $roleName]);
            $this->info("✅ Role '{$roleName}' created/updated");

            // Add permissions if provided
            if ($permissions) {
                $permissionArray = array_map('trim', explode(',', $permissions));
                $this->info("📋 Adding permissions: " . implode(', ', $permissionArray));

                foreach ($permissionArray as $permissionName) {
                    if (empty($permissionName)) {
                        continue;
                    }

                    $permission = Permission::firstOrCreate(['name' => $permissionName]);
                    $role->givePermissionTo($permission);
                    $this->info("  → Added permission: {$permission->name}");
                }
            }

            $this->newLine();
            $this->info("🎉 Role setup complete!");

            // Show summary
            $this->table(
                ['Field', 'Value'],
                [
                    ['Role Name', $role->name],
                    ['Permissions', $role->permissions->pluck('name')->join(', ') ?: 'None'],
                    ['Users with this role', $role->users()->count()],
                ]
            );

            $this->newLine();
            $this->info("💡 To assign this role to a user:");
            $this->info("   php artisan tinker");
            $this->info("   User::find(1)->assignRole('{$roleName}');");

            return 0;

        } catch (\Exception $e) {
            $this->error("❌ Error creating role: " . $e->getMessage());
            return 1;
        }
    }
}
