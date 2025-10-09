<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class CreateTemplateCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'delaine:create-template 
                            {name? : Name of the template}
                            {--description= : Description of the template}
                            {--author= : Author of the template}
                            {--template-version=1.0.0 : Version of the template}
                            {--output=./templates : Output directory for the template}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new Delaine template with proper directory structure and manifest';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $name = $this->argument('name') ?: $this->ask('What is the name of your template?');
        $description = $this->option('description') ?: $this->ask('Describe your template', 'A beautiful template for Delaine');
        $author = $this->option('author') ?: $this->ask('Who is the author?', 'Template Author');
        $version = $this->option('template-version') ?: $this->ask('What version?', '1.0.0');
        $outputDir = $this->option('output');

        $this->info("🎨 Creating Delaine template: {$name}");

        // Create template directory
        $templateDir = $outputDir . '/' . $this->sanitizeName($name);

        if (File::exists($templateDir)) {
            if (!$this->confirm("Template directory already exists. Overwrite?")) {
                $this->info("❌ Template creation cancelled.");
                return 1;
            }
            File::deleteDirectory($templateDir);
        }

        // Create directory structure
        $this->createDirectoryStructure($templateDir);

        // Create manifest file
        $this->createManifest($templateDir, $name, $description, $author, $version);

        // Create sample files
        $this->createSampleFiles($templateDir, $name);

        $this->newLine();
        $this->info("✅ Template created successfully!");
        $this->info("📁 Location: {$templateDir}");
        $this->info("🚀 Next steps:");
        $this->info("   1. Add your styles to: {$templateDir}/styles/");
        $this->info("   2. Add your scripts to: {$templateDir}/scripts/");
        $this->info("   3. Add your components to: {$templateDir}/components/");
        $this->info("   4. Add your layouts to: {$templateDir}/layouts/");
        $this->info("   5. Add your assets to: {$templateDir}/assets/");
        $this->info("   6. Test with: php artisan delaine:integrate-template {$templateDir}");

        return 0;
    }

    /**
     * Create the directory structure for the template
     */
    private function createDirectoryStructure(string $templateDir): void
    {
        $this->info("📁 Creating directory structure...");

        $directories = [
            'styles',
            'scripts',
            'components',
            'layouts',
            'assets/css',
            'assets/js',
            'assets/images',
        ];

        foreach ($directories as $dir) {
            $fullPath = $templateDir . '/' . $dir;
            File::makeDirectory($fullPath, 0755, true);
            $this->line("   ✅ Created: {$dir}/");
        }
    }

    /**
     * Create the manifest file
     */
    private function createManifest(string $templateDir, string $name, string $description, string $author, string $version): void
    {
        $this->info("📄 Creating manifest file...");

        $manifest = [
            'name' => $name,
            'version' => $version,
            'description' => $description,
            'author' => $author,
            'compatibility' => 'delaine:^1.0',
            'files' => [
                'styles' => 'resources/css/templates/',
                'scripts' => 'resources/js/templates/',
                'components' => 'resources/views/components/templates/',
                'layouts' => 'resources/views/layouts/templates/',
                'assets' => 'public/assets/templates/'
            ],
            'dependencies' => [],
            'setup' => [
                'npm run build'
            ],
            'features' => [
                'Modern design',
                'Responsive layout',
                'Tailwind CSS components',
                'Interactive JavaScript'
            ],
            'documentation' => 'https://github.com/your-username/delaine-templates'
        ];

        $manifestPath = $templateDir . '/delaine-template.json';
        File::put($manifestPath, json_encode($manifest, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));

        $this->line("   ✅ Created: delaine-template.json");
    }

    /**
     * Create sample files to help users get started
     */
    private function createSampleFiles(string $templateDir, string $name): void
    {
        $this->info("📝 Creating sample files...");

        // Sample CSS file
        $cssContent = "/* {$name} Template Styles */\n\n";
        $cssContent .= ".template-container {\n";
        $cssContent .= "    @apply min-h-screen bg-gray-50;\n";
        $cssContent .= "}\n\n";
        $cssContent .= ".template-card {\n";
        $cssContent .= "    @apply bg-white rounded-lg shadow-sm border border-gray-200 p-6;\n";
        $cssContent .= "}\n\n";
        $cssContent .= "/* Add your custom styles here */\n";

        File::put($templateDir . '/styles/template.css', $cssContent);
        $this->line("   ✅ Created: styles/template.css");

        // Sample JavaScript file
        $jsContent = "// {$name} Template JavaScript\n\n";
        $jsContent .= "class Template {\n";
        $jsContent .= "    constructor() {\n";
        $jsContent .= "        this.init();\n";
        $jsContent .= "    }\n\n";
        $jsContent .= "    init() {\n";
        $jsContent .= "        this.setupEventListeners();\n";
        $jsContent .= "    }\n\n";
        $jsContent .= "    setupEventListeners() {\n";
        $jsContent .= "        // Add your event listeners here\n";
        $jsContent .= "    }\n";
        $jsContent .= "}\n\n";
        $jsContent .= "// Initialize when DOM is loaded\n";
        $jsContent .= "document.addEventListener('DOMContentLoaded', () => {\n";
        $jsContent .= "    new Template();\n";
        $jsContent .= "});\n";

        File::put($templateDir . '/scripts/template.js', $jsContent);
        $this->line("   ✅ Created: scripts/template.js");

        // Sample Blade component
        $componentContent = "{{-- {$name} Template Component --}}\n";
        $componentContent .= "@props(['title', 'content'])\n\n";
        $componentContent .= "<div class=\"template-card\">\n";
        $componentContent .= "    <h3 class=\"text-lg font-semibold text-gray-900 mb-2\">{{ \$title }}</h3>\n";
        $componentContent .= "    <div class=\"text-gray-600\">{{ \$content }}</div>\n";
        $componentContent .= "</div>\n";

        File::put($templateDir . '/components/template-card.blade.php', $componentContent);
        $this->line("   ✅ Created: components/template-card.blade.php");

        // Sample Blade layout
        $layoutContent = "{{-- {$name} Template Layout --}}\n";
        $layoutContent .= "<!DOCTYPE html>\n";
        $layoutContent .= "<html lang=\"{{ str_replace('_', '-', app()->getLocale()) }}\">\n";
        $layoutContent .= "<head>\n";
        $layoutContent .= "    <meta charset=\"utf-8\">\n";
        $layoutContent .= "    <meta name=\"viewport\" content=\"width=device-width, initial-scale=1\">\n";
        $layoutContent .= "    <meta name=\"csrf-token\" content=\"{{ csrf_token() }}\">\n\n";
        $layoutContent .= "    <title>{{ config('app.name', 'Laravel') }}</title>\n\n";
        $layoutContent .= "    <!-- Fonts -->\n";
        $layoutContent .= "    <link rel=\"preconnect\" href=\"https://fonts.bunny.net\">\n";
        $layoutContent .= "    <link href=\"https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap\" rel=\"stylesheet\" />\n\n";
        $layoutContent .= "    <!-- Scripts -->\n";
        $layoutContent .= "    @vite(['resources/css/app.css', 'resources/js/app.js'])\n";
        $layoutContent .= "</head>\n";
        $layoutContent .= "<body class=\"template-container\">\n";
        $layoutContent .= "    <div class=\"min-h-screen\">\n";
        $layoutContent .= "        {{ \$slot }}\n";
        $layoutContent .= "    </div>\n";
        $layoutContent .= "</body>\n";
        $layoutContent .= "</html>\n";

        File::put($templateDir . '/layouts/template.blade.php', $layoutContent);
        $this->line("   ✅ Created: layouts/template.blade.php");

        // README file
        $readmeContent = "# {$name} Template\n\n";
        $readmeContent .= "A beautiful template for the Delaine framework.\n\n";
        $readmeContent .= "## Features\n\n";
        $readmeContent .= "- Modern design\n";
        $readmeContent .= "- Responsive layout\n";
        $readmeContent .= "- Tailwind CSS components\n";
        $readmeContent .= "- Interactive JavaScript\n\n";
        $readmeContent .= "## Installation\n\n";
        $readmeContent .= "```bash\n";
        $readmeContent .= "php artisan delaine:integrate-template ./path/to/{$this->sanitizeName($name)}\n";
        $readmeContent .= "```\n\n";
        $readmeContent .= "## Usage\n\n";
        $readmeContent .= "After installation, you can use the template components and layouts in your Delaine project.\n\n";
        $readmeContent .= "## Customization\n\n";
        $readmeContent .= "Edit the files in this template to customize the design and functionality.\n";

        File::put($templateDir . '/README.md', $readmeContent);
        $this->line("   ✅ Created: README.md");
    }

    /**
     * Sanitize template name for directory
     */
    private function sanitizeName(string $name): string
    {
        return strtolower(preg_replace('/[^a-zA-Z0-9\-_]/', '-', $name));
    }
}