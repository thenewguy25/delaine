<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Artisan;

class RemoveTemplateCommand extends Command
{
    protected $signature = 'delaine:remove-template {name} {--force}';
    protected $description = 'Remove an installed template';

    public function handle()
    {
        $templateName = $this->argument('name');
        $force = $this->option('force');

        $templatesFile = storage_path('app/delaine-templates.json');

        if (!File::exists($templatesFile)) {
            $this->error('❌ No templates installed.');
            return 1;
        }

        $templates = json_decode(File::get($templatesFile), true);

        if (!isset($templates[$templateName])) {
            $this->error("❌ Template '{$templateName}' not found.");
            $this->info('💡 Use "php artisan delaine:templates" to see installed templates.');
            return 1;
        }

        $template = $templates[$templateName];

        if (!$force && !$this->confirm("Are you sure you want to remove '{$template['name']}'?")) {
            $this->info('❌ Template removal cancelled.');
            return 0;
        }

        $this->info("🗑️  Removing template: {$template['name']}");

        // Note: This is a basic removal - in production you might want to:
        // 1. Rollback migrations
        // 2. Remove files
        // 3. Clean up dependencies

        unset($templates[$templateName]);

        if (empty($templates)) {
            File::delete($templatesFile);
        } else {
            File::put($templatesFile, json_encode($templates, JSON_PRETTY_PRINT));
        }

        $this->info("✅ Template '{$templateName}' removed successfully!");
        $this->warn('⚠️  Note: Template files and database changes were not automatically removed.');
        $this->warn('   You may need to manually clean up files and rollback migrations.');

        return 0;
    }
}
