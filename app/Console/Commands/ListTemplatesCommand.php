<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class ListTemplatesCommand extends Command
{
    protected $signature = 'delaine:templates';
    protected $description = 'List all installed templates';

    public function handle()
    {
        $templatesFile = storage_path('app/delaine-templates.json');

        if (!File::exists($templatesFile)) {
            $this->info('📋 No templates installed yet.');
            $this->newLine();
            $this->info('💡 To install a template:');
            $this->info('   php artisan delaine:integrate-template /path/to/template');
            return 0;
        }

        $templates = json_decode(File::get($templatesFile), true);

        $this->info('📋 Installed Templates:');
        $this->newLine();

        foreach ($templates as $name => $template) {
            $this->info("📦 {$template['name']} (v{$template['version']})");
            $this->line("   Description: {$template['description']}");
            $this->line("   Installed: {$template['installed_at']}");
            $this->newLine();
        }

        return 0;
    }
}
