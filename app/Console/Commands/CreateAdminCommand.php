<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class CreateAdminCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:admin 
                            {name? : Name of the admin user}
                            {email? : Email of the admin user}
                            {password? : Password for the admin user}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create an admin user with full permissions for the Delaine framework';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $this->info('🚀 Creating Admin User for Delaine Framework...');
        $this->newLine();

        // Get user input
        $name = $this->argument('name') ?: $this->ask('What is the admin\'s name?', 'Admin User');
        $email = $this->argument('email') ?: $this->ask('What is the admin\'s email?', 'admin@delaine.test');
        $password = $this->argument('password') ?: $this->secret('What is the admin\'s password? (min 8 characters)');

        // Validate inputs
        if (empty($password) || strlen($password) < 8) {
            $this->error('❌ Password must be at least 8 characters long.');
            return 1;
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $this->error('❌ Please provide a valid email address.');
            return 1;
        }

        try {
            // Ensure roles and permissions exist
            $this->ensureRolesAndPermissions();

            // Check if user already exists
            $existingUser = User::where('email', $email)->first();
            if ($existingUser) {
                if ($this->confirm("User with email '{$email}' already exists. Do you want to assign admin role to this user?")) {
                    $existingUser->assignRole('admin');
                    $this->info("✅ Admin role assigned to existing user: {$existingUser->name}");
                    return 0;
                } else {
                    $this->info('❌ Operation cancelled.');
                    return 1;
                }
            }

            // Create the admin user
            $user = User::create([
                'name' => $name,
                'email' => $email,
                'password' => Hash::make($password),
                'email_verified_at' => now(),
            ]);

            // Ensure email is verified (double-check)
            $user->markEmailAsVerified();

            // Assign admin role
            $user->assignRole('admin');

            $this->newLine();
            $this->info('✅ Admin user created successfully!');
            $this->table(
                ['Field', 'Value'],
                [
                    ['Name', $user->name],
                    ['Email', $user->email],
                    ['Role', 'admin'],
                    ['Permissions', 'manage users'],
                    ['Email Verified', 'Yes'],
                ]
            );

            $this->newLine();
            $this->info('🔗 You can now login at: ' . url('/login'));
            $this->info('👑 Admin panel available at: ' . url('/admin/users'));

            return 0;

        } catch (\Exception $e) {
            $this->error('❌ Error creating admin user: ' . $e->getMessage());
            return 1;
        }
    }

    /**
     * Ensure that required roles and permissions exist
     */
    private function ensureRolesAndPermissions(): void
    {
        $this->info('🔧 Setting up roles and permissions...');

        // Create admin role if it doesn't exist
        $adminRole = Role::firstOrCreate(['name' => 'admin']);

        // Create user role if it doesn't exist
        Role::firstOrCreate(['name' => 'user']);

        // Create manage users permission if it doesn't exist
        $manageUsersPermission = Permission::firstOrCreate(['name' => 'manage users']);

        // Assign permission to admin role
        if (!$adminRole->hasPermissionTo('manage users')) {
            $adminRole->givePermissionTo('manage users');
        }

        $this->info('✅ Roles and permissions configured');
    }
}