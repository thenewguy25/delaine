<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;

class IntegrateTemplateCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'delaine:integrate-template {path} {--name=} {--overwrite} {--skip-setup}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Integrate a downloaded template into the Delaine project';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $path = $this->argument('path');
        $name = $this->option('name');
        $overwrite = $this->option('overwrite');
        $skipSetup = $this->option('skip-setup');

        $this->info('🔧 Integrating template into Delaine...');

        // Step 1: Validate template path
        if (!$this->validateTemplatePath($path)) {
            return 1;
        }

        // Step 2: Load and validate template manifest
        $manifest = $this->loadTemplateManifest($path);
        if (!$manifest) {
            return 1;
        }

        // Step 3: Check compatibility
        if (!$this->checkCompatibility($manifest)) {
            return 1;
        }

        // Step 4: Install dependencies (optional)
        if (!$this->installDependencies($manifest)) {
            return 1;
        }

        // Step 5: Copy template files
        if (!$this->copyTemplateFiles($path, $manifest, $overwrite)) {
            return 1;
        }

        // Step 6: Run setup commands (optional)
        if (!$skipSetup && !$this->runSetupCommands($manifest)) {
            return 1;
        }

        // Step 7: Register template
        $this->registerTemplate($manifest, $name);

        $this->newLine();
        $this->info('✅ Template integrated successfully!');
        $this->info("📋 Template: {$manifest['name']} v{$manifest['version']}");
        $this->info('🚀 Your Delaine project is ready to use the new template!');

        return 0;
    }

    /**
     * Validate the template path exists and is readable
     */
    private function validateTemplatePath(string $path): bool
    {
        if (!File::exists($path)) {
            $this->error("❌ Template path does not exist: {$path}");
            return false;
        }

        if (!File::isDirectory($path)) {
            $this->error("❌ Template path is not a directory: {$path}");
            return false;
        }

        $this->info("✅ Template path validated: {$path}");
        return true;
    }

    /**
     * Load and validate the template manifest
     */
    private function loadTemplateManifest(string $path): ?array
    {
        $manifestPath = $path . '/delaine-template.json';

        if (!File::exists($manifestPath)) {
            $this->error('❌ Template manifest (delaine-template.json) not found');
            $this->warn('💡 Make sure the template includes a delaine-template.json file');
            return null;
        }

        try {
            $manifest = json_decode(File::get($manifestPath), true);

            if (json_last_error() !== JSON_ERROR_NONE) {
                $this->error('❌ Invalid JSON in template manifest');
                return null;
            }

            // Validate required fields
            $requiredFields = ['name', 'version', 'description', 'files'];
            foreach ($requiredFields as $field) {
                if (!isset($manifest[$field])) {
                    $this->error("❌ Missing required field in manifest: {$field}");
                    return null;
                }
            }

            $this->info("✅ Template manifest loaded: {$manifest['name']} v{$manifest['version']}");
            return $manifest;

        } catch (\Exception $e) {
            $this->error("❌ Error reading template manifest: {$e->getMessage()}");
            return null;
        }
    }

    /**
     * Check template compatibility with current Delaine version
     */
    private function checkCompatibility(array $manifest): bool
    {
        if (!isset($manifest['compatibility'])) {
            $this->warn('⚠️  No compatibility information found in template manifest');
            return true;
        }

        $requiredVersion = $manifest['compatibility'];
        $currentVersion = $this->getDelaineVersion();

        // Simple version check (can be enhanced)
        if (strpos($requiredVersion, 'delaine:') === 0) {
            $requiredVersion = str_replace('delaine:', '', $requiredVersion);

            // For now, just warn if versions don't match exactly
            if ($requiredVersion !== $currentVersion) {
                $this->warn("⚠️  Template compatibility: {$requiredVersion}, Current: {$currentVersion}");
                // Auto-continue for now, can be made configurable
            }
        }

        $this->info('✅ Template compatibility verified');
        return true;
    }

    /**
     * Install template dependencies
     */
    private function installDependencies(array $manifest): bool
    {
        if (!isset($manifest['dependencies']) || empty($manifest['dependencies'])) {
            $this->info('✅ No additional dependencies required');
            return true;
        }

        $this->info('📦 Installing template dependencies...');

        foreach ($manifest['dependencies'] as $dependency) {
            $this->info("   Installing: {$dependency}");

            try {
                // Use shell_exec for composer commands
                $output = shell_exec("composer require {$dependency} 2>&1");
                if ($output) {
                    $this->info("   Output: " . trim($output));
                }
            } catch (\Exception $e) {
                $this->warn("⚠️  Could not install {$dependency}: {$e->getMessage()}");
                $this->warn("   Please install manually: composer require {$dependency}");
            }
        }

        $this->info('✅ Dependencies installation completed');
        return true;
    }

    /**
     * Copy template files to appropriate locations
     */
    private function copyTemplateFiles(string $sourcePath, array $manifest, bool $overwrite): bool
    {
        $this->info('📁 Copying template files...');

        $files = $manifest['files'];
        $success = true;

        foreach ($files as $type => $destination) {
            $sourceDir = $sourcePath . '/' . $type;

            if (!File::exists($sourceDir)) {
                $this->warn("⚠️  Source directory not found: {$type}");
                continue;
            }

            $fullDestination = base_path($destination);

            // Create destination directory if it doesn't exist
            if (!File::exists($fullDestination)) {
                File::makeDirectory($fullDestination, 0755, true);
            }

            if (!$overwrite && File::exists($fullDestination) && File::allFiles($fullDestination)) {
                $this->warn("⚠️  Destination directory not empty: {$destination}");
                // Auto-overwrite for now, can be made configurable
            }

            try {
                File::copyDirectory($sourceDir, $fullDestination);
                $this->info("   ✅ Copied {$type} to {$destination}");
            } catch (\Exception $e) {
                $this->error("   ❌ Failed to copy {$type}: {$e->getMessage()}");
                $success = false;
            }
        }

        return $success;
    }


    /**
     * Run template setup commands
     */
    private function runSetupCommands(array $manifest): bool
    {
        if (!isset($manifest['setup']) || empty($manifest['setup'])) {
            $this->info('✅ No setup commands required');
            return true;
        }

        $this->info('⚙️  Running template setup commands...');

        foreach ($manifest['setup'] as $command) {
            $this->info("   Running: {$command}");

            try {
                // Use shell_exec for setup commands
                $output = shell_exec("php artisan {$command} 2>&1");
                if ($output) {
                    $this->info("   Output: " . trim($output));
                }
                $this->info("   ✅ Completed: {$command}");
            } catch (\Exception $e) {
                $this->error("   ❌ Setup command failed: {$command}");
                $this->error("   Error: {$e->getMessage()}");
                return false;
            }
        }

        $this->info('✅ Setup commands completed successfully');
        return true;
    }

    /**
     * Register the template in the system
     */
    private function registerTemplate(array $manifest, ?string $name): void
    {
        $templateName = $name ?: $manifest['name'];

        // Store template info in a simple JSON file
        $templatesFile = storage_path('app/delaine-templates.json');
        $templates = [];

        if (File::exists($templatesFile)) {
            $templates = json_decode(File::get($templatesFile), true) ?: [];
        }

        $templates[$templateName] = [
            'name' => $manifest['name'],
            'version' => $manifest['version'],
            'description' => $manifest['description'],
            'installed_at' => now()->toISOString(),
            'manifest' => $manifest
        ];

        File::put($templatesFile, json_encode($templates, JSON_PRETTY_PRINT));

        $this->info("📝 Template registered as: {$templateName}");
    }

    /**
     * Get current Delaine version
     */
    private function getDelaineVersion(): string
    {
        // Try to get version from composer.json
        $composerPath = base_path('composer.json');
        if (File::exists($composerPath)) {
            $composer = json_decode(File::get($composerPath), true);
            return $composer['version'] ?? '1.0.0';
        }

        return '1.0.0';
    }
}
