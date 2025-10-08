# Delaine Template System

The Delaine framework includes a powerful template integration system focused on **styles, formatting, and frontend components**. This allows developers to download beautiful templates from anywhere and integrate their visual design seamlessly into their Delaine projects.

## 🚀 Quick Start

### Installing a Template

```bash
# Download a template from anywhere (GitHub, Tailwind UI, Creative Market, etc.)
# Then integrate it into your Delaine project
php artisan delaine:integrate-template /path/to/template

# Example with sample dashboard template
php artisan delaine:integrate-template ./templates/sample-blog
```

### Managing Templates

```bash
# List all installed templates
php artisan delaine:templates

# Remove a template
php artisan delaine:remove-template dashboard-template
```

## 📋 Template Structure

A Delaine template should have the following structure:

```
template-name/
├── delaine-template.json    # Template manifest (required)
├── styles/                 # CSS files
├── scripts/                # JavaScript files
├── components/             # Blade components
├── layouts/                # Blade layouts
└── assets/                 # Images, fonts, etc.
    ├── css/
    ├── js/
    └── images/
```

## 📄 Template Manifest

Every template must include a `delaine-template.json` file:

```json
{
    "name": "Modern Dashboard Template",
    "version": "1.0.0",
    "description": "Clean, modern dashboard design with Tailwind CSS",
    "author": "Template Author",
    "compatibility": "delaine:^1.0",
    "files": {
        "styles": "resources/css/templates/",
        "scripts": "resources/js/templates/",
        "components": "resources/views/components/templates/",
        "layouts": "resources/views/layouts/templates/",
        "assets": "public/assets/templates/"
    },
    "dependencies": [],
    "setup": ["npm run build"]
}
```

### Manifest Fields

-   **name**: Template display name
-   **version**: Template version
-   **description**: Brief description
-   **author**: Template author
-   **compatibility**: Required Delaine version
-   **files**: File mapping (source → destination)
-   **dependencies**: Composer packages to install (optional)
-   **setup**: Commands to run after installation (optional)

## 🛠️ Creating Templates

### 1. Create Template Structure

```bash
mkdir my-template
cd my-template
mkdir -p {styles,scripts,components,layouts,assets/{css,js,images}}
```

### 2. Create Manifest

Create `delaine-template.json` with your template configuration.

### 3. Add Template Files

Place your files in the appropriate directories:

-   **styles**: CSS files (Tailwind, custom CSS)
-   **scripts**: JavaScript files (interactions, animations)
-   **components**: Blade components (reusable UI elements)
-   **layouts**: Blade layouts (page structures)
-   **assets**: Images, fonts, static files

### 4. Test Template

```bash
# Test your template
php artisan delaine:integrate-template ./my-template
```

## 📦 Available Templates

### Modern Dashboard Template

A clean, modern dashboard design with Tailwind CSS components.

**Features:**

-   Responsive sidebar navigation
-   Modern card components
-   Interactive JavaScript
-   Professional color scheme
-   Mobile-friendly design

**Installation:**

```bash
php artisan delaine:integrate-template ./templates/sample-blog
```

## 🔧 Advanced Usage

### Custom Installation Options

```bash
# Install with custom name
php artisan delaine:integrate-template ./template --name=my-dashboard

# Overwrite existing files
php artisan delaine:integrate-template ./template --overwrite

# Skip setup commands
php artisan delaine:integrate-template ./template --skip-setup
```

### Template Dependencies

Templates can specify Composer dependencies (optional):

```json
{
    "dependencies": ["spatie/laravel-permission"]
}
```

### Setup Commands

Templates can run setup commands after installation:

```json
{
    "setup": ["npm run build", "php artisan storage:link"]
}
```

## 🎯 Real-World Example

### Team Member Downloads Tailwind Template

```bash
# Downloads from Tailwind UI
tailwind-dashboard-template/
├── index.html
├── dashboard.html
├── components/
├── styles/
└── scripts/
```

### Team Member Converts It

```bash
# Converts to Delaine format
dashboard-template/
├── delaine-template.json
├── styles/
│   └── dashboard.css
├── scripts/
│   └── dashboard.js
├── components/
│   └── dashboard-card.blade.php
├── layouts/
│   └── dashboard.blade.php
└── assets/
    ├── css/
    ├── js/
    └── images/
```

### Team Member Integrates

```bash
php artisan delaine:integrate-template ./dashboard-template

# Result: Beautiful dashboard integrated into Delaine!
# - Styles work with Delaine's Tailwind setup
# - Components integrate with Delaine's Blade system
# - Scripts work with Delaine's Vite build process
# - Layouts extend Delaine's base layout
```

## 🚨 Troubleshooting

### Common Issues

**Template manifest not found:**

-   Ensure `delaine-template.json` exists in template root
-   Check JSON syntax is valid

**File conflicts:**

-   Use `--overwrite` flag to replace existing files
-   Check file permissions

**Build errors:**

-   Use `--skip-setup` to skip build commands
-   Run `npm run build` manually if needed

### Getting Help

-   Check template documentation
-   Review template manifest
-   Check Laravel logs for errors
-   Ensure all dependencies are installed

## 🎯 Best Practices

### For Template Creators

1. **Focus on Frontend**: Templates should provide styles, components, and layouts
2. **Use Delaine's Features**: Integrate with Delaine's ACL, user system, etc.
3. **Responsive Design**: Ensure templates work on all devices
4. **Clean Code**: Use semantic HTML and organized CSS
5. **Documentation**: Include clear setup instructions

### For Template Users

1. **Backup First**: Always backup before installing templates
2. **Test Environment**: Test templates in development first
3. **Read Documentation**: Review template requirements
4. **Check Compatibility**: Ensure template works with your setup
5. **Customize**: Modify templates to fit your project needs

## 🔗 Integration with Delaine

Templates integrate seamlessly with Delaine's existing features:

-   **ACL System**: Templates can use existing roles and permissions
-   **Admin Panel**: Templates can extend the admin interface
-   **User Management**: Templates can integrate with user system
-   **Blade Components**: Templates can create reusable components
-   **Vite Build**: Templates work with Delaine's asset pipeline

## 💡 Template Types

### Dashboard Templates

-   Admin panels
-   Analytics dashboards
-   User management interfaces

### Landing Page Templates

-   Marketing pages
-   Product showcases
-   Portfolio sites

### Component Libraries

-   Form components
-   Navigation components
-   Data display components

---

**Happy templating! 🎉**
