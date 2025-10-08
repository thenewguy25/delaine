# 🚀 Delaine Framework

A modern Laravel-based web application framework designed for rapid development with built-in authentication, ACL (Access Control List), and admin dashboard capabilities.

## ✨ Features

-   **🔐 Complete Authentication System**

    -   User registration and login
    -   Email verification (auto-verified in local environment)
    -   Password reset functionality
    -   Rate limiting and security measures

-   **👑 Admin Dashboard & ACL**

    -   Role-based access control using Spatie Laravel Permission
    -   Admin user management interface
    -   User impersonation capabilities
    -   Permission-based route protection

-   **🐳 Docker Ready**

    -   Complete Docker Compose setup
    -   MySQL database container
    -   Mailpit for email testing
    -   Hot reload for development

-   **⚡ Developer Tools**

    -   Custom Artisan commands for admin creation
    -   ACL verification tools
    -   Comprehensive error handling
    -   Modern Blade components with Tailwind CSS

-   **🧪 Comprehensive Testing**

    -   64 unit tests covering all core functionality
    -   User management, ACL, invitations, middleware, and admin features
    -   Automated test database setup with RefreshDatabase
    -   CI/CD ready with detailed test documentation

-   **🚀 GitHub Actions CI/CD**
    -   Automated testing on every push and PR
    -   Code quality checks with PHPStan and PHP CS Fixer
    -   Automated deployments to staging and production
    -   Manual workflow triggers for on-demand testing

## 🛠️ Prerequisites

Before you begin, ensure you have the following installed:

-   **PHP 8.2+** with extensions: `bcmath`, `ctype`, `curl`, `dom`, `fileinfo`, `json`, `mbstring`, `openssl`, `pdo`, `tokenizer`, `xml`
-   **Composer** (latest version)
-   **Node.js 18+** and **npm**
-   **Docker** and **Docker Compose** (for containerized setup)
-   **Git**

## 🚀 Quick Start

### Option 1: Docker Setup (Recommended)

1. **Clone the repository**

    ```bash
    git clone https://github.com/thenewguy25/delaine.git
    cd delaine
    ```

2. **Set up environment**

    ```bash
    cp .env.example .env
    ```

3. **Start Docker services** (This will automatically run all setup commands via `start.sh`)

    ```bash
    docker-compose up -d
    ```

4. **Create admin user**

    ```bash
    docker-compose exec app php artisan make:admin
    ```

5. **Access your application**
    - **Web App**: http://localhost:8000
    - **Admin Panel**: http://localhost:8000/admin/users
    - **Mailpit**: http://localhost:8025

> **Note**: The `start.sh` script automatically handles:
>
> -   Installing PHP dependencies (`composer install`)
> -   Installing Node.js dependencies (`npm install`)
> -   Generating application key (`php artisan key:generate`)
> -   Running database migrations (`php artisan migrate`)
> -   Starting Laravel server and Vite dev server

### Option 2: Local Development Setup

1. **Clone and navigate**

    ```bash
    git clone https://github.com/thenewguy25/delaine.git
    cd delaine
    ```

2. **Install dependencies**

    ```bash
    composer install
    npm install
    ```

3. **Environment setup**

    ```bash
    cp .env.example .env
    ```

4. **Configure database** (Update `.env` file)

    ```env
    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=delaine_local
    DB_USERNAME=root
    DB_PASSWORD=your_password
    ```

5. **Generate key and migrate**

    ```bash
    php artisan key:generate
    php artisan migrate
    ```

6. **Create admin user**

    ```bash
    php artisan make:admin
    ```

7. **Build assets and serve**
    ```bash
    npm run build
    php artisan serve
    ```

## 🎨 Phase 8: Dashboard UI Improvements

### **Enhanced Admin Dashboard**

-   **Statistics Cards**: Real-time user counts (total, active, inactive, admin)
-   **Quick Actions**: Direct links to user management, invitations, and user creation
-   **Recent Users**: Overview of latest registered users
-   **Responsive Design**: Mobile-friendly layout with Tailwind CSS

### **Advanced User Management**

-   **Enhanced Filters**: Search by name/email, filter by status and role
-   **Improved Action Buttons**: Color-coded buttons with icons for better UX
-   **Smart Pagination**: Shows result counts and improved navigation

### **Notification System**

-   **Reusable Component**: `<x-notification>` component for consistent messaging
-   **Multiple Types**: Success, error, warning, and info notifications
-   **Icon Integration**: Visual indicators for different message types

### **UI Enhancements**

-   **Better Visual Hierarchy**: Improved spacing, colors, and typography
-   **Interactive Elements**: Hover effects, focus states, and transitions
-   **Accessibility**: Proper labels, ARIA attributes, and keyboard navigation
-   **Consistent Styling**: Unified design language across all admin pages

## 🔧 Available Commands

### Admin Management

```bash
# Create a new admin user
php artisan make:admin

# Verify ACL setup
php artisan verify:acl
```

### Development

```bash
# Start development server
php artisan serve

# Watch for changes (with Docker)
docker-compose exec app npm run dev

# Clear caches
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear
```

## 📁 Project Structure

```
delaine/
├── app/
│   ├── Console/Commands/          # Custom Artisan commands
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── Admin/            # Admin controllers
│   │   │   └── Auth/             # Authentication controllers
│   │   ├── Middleware/           # Custom middleware
│   │   └── Requests/             # Form request validation
│   └── Models/                   # Eloquent models
├── config/                       # Configuration files
├── database/
│   ├── migrations/               # Database migrations
│   └── seeders/                  # Database seeders
├── resources/
│   ├── views/
│   │   ├── admin/                # Admin dashboard views
│   │   ├── auth/                 # Authentication views
│   │   └── components/           # Blade components
│   └── css/                      # Stylesheets
├── routes/
│   ├── web.php                   # Web routes
│   └── auth.php                  # Authentication routes
└── docker-compose.yml           # Docker configuration
```

## 🔐 Authentication & Authorization

### Default Roles & Permissions

-   **Admin Role**: Full access to admin panel

    -   `manage users` permission

-   **User Role**: Standard user access
    -   Basic profile management

### Creating Admin Users

```bash
php artisan make:admin
```

This command will:

-   Create a new admin user
-   Assign the admin role
-   Grant manage users permission
-   Auto-verify email for local development

### Adding Custom Roles

#### Quick Role Addition

```bash
# Add a single role with permissions
php artisan role:add moderator "moderate content,manage comments"

# Add a role without permissions
php artisan role:add editor
```

#### Bulk Role Setup

```bash
# Install all default roles and permissions
php artisan db:seed --class=RoleSeeder
```

#### Manual Role Assignment

```bash
# Assign role to user
php artisan tinker
User::find(1)->assignRole('moderator');

# Check user roles
User::find(1)->roles;

# Remove role from user
User::find(1)->removeRole('moderator');
```

### User Impersonation

Admins can impersonate other users to test the user experience:

#### Features

-   **Start Impersonation**: Click "Impersonate" button in user management
-   **Visual Indicators**: Purple notice shows when impersonating
-   **Stop Impersonation**: "Stop Impersonating" button in navigation
-   **Safety Checks**: Cannot impersonate inactive users or yourself

#### Usage

1. Go to Admin Panel → User Management
2. Click "Impersonate" next to any active user
3. You'll be logged in as that user
4. Use "Stop Impersonating" to return to your admin account

### Available Commands

-   **`php artisan make:admin`** - Create admin user
-   **`php artisan role:add <name> [permissions]`** - Add custom role
-   **`php artisan db:seed --class=RoleSeeder`** - Setup all roles
-   **`php artisan verify:acl`** - Verify ACL setup

### Protecting Routes

```php
// Require admin role
Route::middleware(['auth', 'role:admin'])->group(function () {
    // Admin routes
});

// Require specific permission
Route::middleware(['auth', 'permission:manage users'])->group(function () {
    // Permission-protected routes
});

// Require multiple roles
Route::middleware(['auth', 'role:admin|moderator'])->group(function () {
    // Admin or moderator routes
});
```

## 🐳 Docker Configuration

### Services

-   **app**: Laravel application (PHP 8.2, Apache)
    -   **URL**: http://localhost:8000
-   **db**: MySQL 8.0 database
    -   **Port**: 3306
-   **mailpit**: Email testing service
    -   **Web UI**: http://localhost:8025
    -   **SMTP Port**: 1025

### Accessing Services

-   **Application**: http://localhost:8000
-   **Mailpit (Email Testing)**: http://localhost:8025
-   **Database**: localhost:3306

### Environment Variables

The Docker setup uses these default credentials:

-   **Database**: `delaine` / `delaine_user` / `secret`
-   **Root Password**: `root`

## 🔧 Environment Configuration

### Local Development (.env)

```env
APP_ENV=local
APP_DEBUG=true
DB_DATABASE=delaine_local
MAIL_MAILER=smtp
MAIL_HOST=127.0.0.1
MAIL_PORT=1025
```

### Production Considerations

```env
APP_ENV=production
APP_DEBUG=false
SESSION_ENCRYPT=true
SESSION_LIFETIME=60
```

## 🧪 Testing the Setup

1. **Verify ACL Setup**

    ```bash
    php artisan verify:acl
    ```

2. **Test Authentication**

    - Register a new user at `/register`
    - Login at `/login`
    - Access dashboard at `/dashboard`

3. **Test Admin Panel**
    - Login as admin user
    - Access `/admin/users`
    - Verify user management features

## 🧪 Testing

Delaine includes a comprehensive unit test suite covering all core functionality. The tests ensure code quality, catch regressions, and provide confidence when making changes.

### Test Coverage

The test suite includes **64 unit tests** covering:

-   **User Management** (14 tests)

    -   User creation and attributes
    -   Role assignment and management
    -   Permission checking through roles
    -   User activation/deactivation functionality
    -   Active/inactive user scoping

-   **ACL System** (13 tests)

    -   Role and permission creation
    -   Permission assignment to roles
    -   Role assignment to users
    -   Permission checking (direct and through roles)
    -   User scoping by roles and permissions

-   **Invitation System** (15 tests)

    -   Invitation creation and token generation
    -   Expiry and usage status checking
    -   Invitation validation logic
    -   Marking invitations as used
    -   Extending invitation expiry

-   **Security Middleware** (7 tests)

    -   Active user access allowance
    -   Inactive user blocking
    -   Session invalidation for inactive users
    -   Unauthenticated user handling

-   **Admin Features** (13 tests)
    -   User impersonation functionality
    -   Impersonation status checking
    -   Edge cases and security measures

### Running Tests

#### Prerequisites

Ensure you have a test database configured. The tests use Laravel's built-in testing features with `RefreshDatabase` trait.

#### Local Testing

```bash
# Run all unit tests
php artisan test --testsuite=Unit

# Run specific test classes
php artisan test tests/Unit/UserTest.php
php artisan test tests/Unit/AclTest.php
php artisan test tests/Unit/InvitationTest.php
php artisan test tests/Unit/CheckActiveUserMiddlewareTest.php
php artisan test tests/Unit/ImpersonationTest.php

# Run tests with verbose output
php artisan test --testsuite=Unit --verbose

# Run tests and stop on first failure
php artisan test --testsuite=Unit --stop-on-failure

# Run tests with coverage (requires Xdebug)
php artisan test --testsuite=Unit --coverage
```

#### Docker Testing

```bash
# Run tests inside Docker container
docker-compose exec app php artisan test --testsuite=Unit

# Run tests with verbose output
docker-compose exec app php artisan test --testsuite=Unit --verbose
```

#### Test Database Setup

The tests automatically:

-   Use `RefreshDatabase` trait to reset database between tests
-   Create unique roles/permissions to avoid conflicts
-   Set up proper test data using factories

#### Continuous Integration

Delaine includes comprehensive GitHub Actions workflows for CI/CD:

-   **CI/CD Pipeline**: Full test suite, code quality checks, and automated deployments
-   **Pull Request Checks**: Quick validation for PRs with automatic comments
-   **Deployment Management**: Automated staging and production deployments
-   **Manual Testing**: On-demand test execution with configurable options

See [`.github/README.md`](.github/README.md) for detailed workflow documentation.

**Quick GitHub Actions Setup:**

```yaml
# Example workflow step
- name: Run Unit Tests
  run: |
      php artisan test --testsuite=Unit --stop-on-failure
```

## 🚀 CI/CD Pipeline

Delaine includes a complete GitHub Actions CI/CD pipeline with automated testing, code quality checks, security scanning, and deployments.

### 📋 Available Workflows

#### 1. **Main CI/CD Pipeline** (`ci.yml`)

**Triggers:** Push to `main`/`develop`, Pull Requests

**Features:**

-   ✅ **Automated Testing**: Runs all 64 unit tests with MySQL service
-   🏗️ **Asset Building**: Compiles frontend assets with npm
-   🔍 **Code Quality**: PHP CS Fixer, PHPStan, dependency audits
-   🐳 **Docker Testing**: Validates Docker image builds
-   🚀 **Auto-Deploy**: Deploys to staging (`develop`) and production (`main`)
-   📢 **Notifications**: Team alerts on success/failure

#### 2. **Pull Request Checks** (`pr-checks.yml`)

**Triggers:** Pull Requests only

**Features:**

-   ⚡ **Quick Validation**: Fast unit test execution
-   🏗️ **Build Verification**: Frontend asset compilation
-   🔒 **Security Audit**: Dependency vulnerability checks
-   💬 **Auto Comments**: Test results posted to PR

#### 3. **Deployment Management** (`deploy.yml`)

**Triggers:** Push to `main` + manual dispatch

**Features:**

-   🌍 **Environment Deployments**: Staging and production
-   💾 **Backup Creation**: Pre-deployment backups
-   🏥 **Health Checks**: Post-deployment validation
-   🔄 **Auto Rollback**: Failure recovery

#### 5. **Manual Testing** (`test.yml`)

**Triggers:** Manual dispatch only

**Features:**

-   🎯 **Configurable Tests**: Unit/Feature/All test suites
-   📊 **Coverage Reports**: Optional test coverage
-   🔍 **Verbose Output**: Detailed test logging
-   🐛 **Debug Mode**: On-demand testing for troubleshooting

### 🎯 Workflow Triggers

| Workflow       | Push to main | Push to develop | PR  | Manual |
| -------------- | ------------ | --------------- | --- | ------ |
| CI/CD Pipeline | ✅           | ✅              | ✅  | ❌     |
| PR Checks      | ❌           | ❌              | ✅  | ❌     |
| Deploy         | ✅           | ❌              | ❌  | ✅     |
| Manual Tests   | ❌           | ❌              | ❌  | ✅     |

### 🔧 Setup Instructions

#### 1. **Repository Secrets**

Add these secrets in GitHub Settings → Secrets and variables → Actions:

**For Deployment:**

```
STAGING_HOST=your-staging-server.com
STAGING_USER=deploy-user
STAGING_KEY=your-ssh-private-key
PRODUCTION_HOST=your-production-server.com
PRODUCTION_USER=deploy-user
PRODUCTION_KEY=your-ssh-private-key
```

**For Notifications (Optional):**

```
SLACK_WEBHOOK=https://hooks.slack.com/services/...
DISCORD_WEBHOOK=https://discord.com/api/webhooks/...
```

#### 2. **Environment Configuration**

Set up environments in GitHub Settings → Environments:

-   **staging**: For staging deployments
-   **production**: For production deployments

#### 3. **Branch Protection Rules**

Configure branch protection for `main`:

-   Require status checks to pass
-   Require branches to be up to date
-   Require pull request reviews

### 🚀 Usage Examples

#### Running Tests Manually

1. Go to **Actions** → **Test Suite**
2. Click **Run workflow**
3. Select test suite (Unit/Feature/All)
4. Choose options (verbose, coverage)
5. Click **Run workflow**

#### Deploying to Production

1. Go to **Actions** → **Deploy**
2. Click **Run workflow**
3. Select **production** environment
4. Click **Run workflow**

### 📊 Pipeline Status

**Green ✅**: All checks passed - ready for deployment
**Yellow ⚠️**: Some checks failed - review logs
**Red ❌**: Critical failures - deployment blocked

### 🛠️ Customization

#### Adding New Tests

```yaml
# In ci.yml, add new test step
- name: Run custom tests
  run: php artisan test --testsuite=Custom
```

#### Custom Deployment Commands

```yaml
# In deploy.yml, replace example commands
- name: Deploy to server
  run: |
      scp delaine-production.tar.gz ${{ secrets.PRODUCTION_USER }}@${{ secrets.PRODUCTION_HOST }}:/var/www/
      ssh ${{ secrets.PRODUCTION_USER }}@${{ secrets.PRODUCTION_HOST }} "cd /var/www && tar -xzf delaine-production.tar.gz"
```

#### Environment Variables

```yaml
# Add custom environment variables
env:
    CUSTOM_VAR: ${{ secrets.CUSTOM_SECRET }}
    APP_ENV: production
```

### 🔍 Monitoring & Debugging

#### Viewing Workflow Logs

1. Go to **Actions** tab
2. Click on workflow run
3. Expand failed step
4. Review logs for errors

#### Common Issues

**Test Failures:**

```bash
# Check database connection
php artisan migrate --env=testing

# Clear caches
php artisan config:clear --env=testing
```

**Deployment Issues:**

-   Verify SSH key permissions
-   Check server connectivity
-   Review deployment logs

### 📈 Metrics & Reports

-   **Test Coverage**: Uploaded to Codecov
-   **Build Artifacts**: Stored for 90 days
-   **Deployment History**: Tracked in Actions

### 🎉 Benefits

-   **Automated Quality Assurance**: Every change is tested
-   **Faster Development**: Quick feedback on PRs
-   **Reliable Deployments**: Automated with rollback
-   **Team Collaboration**: Clear status and notifications

#### Test Results

When all tests pass, you should see:

```
Tests:    64 passed (166 assertions)
Duration: 0.52s
```

#### Writing New Tests

When adding new features, follow these patterns:

```php
<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

class YourFeatureTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_do_something()
    {
        // Arrange
        $user = User::factory()->create();

        // Act
        $result = $user->someMethod();

        // Assert
        $this->assertTrue($result);
    }
}
```

#### Test Best Practices

1. **Use descriptive test names** that explain what is being tested
2. **Follow AAA pattern**: Arrange, Act, Assert
3. **Use factories** for creating test data
4. **Test edge cases** and error conditions
5. **Keep tests isolated** - each test should be independent
6. **Use unique identifiers** to avoid conflicts between tests

#### Troubleshooting Tests

**Database Issues**

```bash
# Reset test database
php artisan migrate:fresh --env=testing

# Clear test cache
php artisan config:clear --env=testing
```

**Permission Conflicts**

```bash
# Clear permission cache
php artisan permission:cache-reset
```

**Memory Issues**

```bash
# Run tests with increased memory
php -d memory_limit=512M artisan test --testsuite=Unit
```

## 🚨 Troubleshooting

### Common Issues

**Database Connection Error**

```bash
# Check if database is running
docker-compose ps

# Restart database
docker-compose restart db

# If start.sh didn't run properly, restart the app container
docker-compose restart app
```

**Permission Errors**

```bash
# Verify ACL setup
php artisan verify:acl

# Re-run migrations
php artisan migrate:fresh
```

**Asset Build Issues**

```bash
# Clear npm cache
npm cache clean --force

# Reinstall dependencies
rm -rf node_modules package-lock.json
npm install
```

**Email Verification Issues**

-   Check Mailpit at http://localhost:8025
-   Verify SMTP settings in `.env`

### CI/CD Troubleshooting

#### Common CI/CD Issues and Solutions

**1. "tar: .: file changed as we read it" Error**
This error occurs when files are being modified during the tar creation process. Our solution:

-   Uses `zip` instead of `tar` for more reliable packaging
-   Creates a clean copy in `/tmp/` before packaging
-   Excludes problematic directories (`node_modules`, `.git`, etc.)

**2. Deprecated GitHub Actions**

-   Updated `actions/upload-artifact` from `v3` to `v4`
-   All workflows use current action versions

**3. PHP CS Fixer Configuration**

-   Fixed by adding path parameter: `php-cs-fixer fix . --dry-run`
-   Ensures proper file discovery

**4. Docker Build Context Issues**

-   Fixed by specifying working directory: `--workdir /var/www/html`
-   Ensures `artisan` command runs in correct context

#### Testing Deployment Locally

You can test the deployment package creation locally:

```bash
# Run the test script
./test-deployment.sh

# Or manually test the process
mkdir -p /tmp/delaine-test
rsync -av --exclude='.git' --exclude='node_modules' --exclude='tests' --exclude='.github' --exclude='docker-compose.yml' --exclude='Dockerfile' --exclude='.env.example' --exclude='public/build' --exclude='vendor' . /tmp/delaine-test/
cd /tmp/delaine-test
composer install --no-progress --prefer-dist --optimize-autoloader --no-dev
npm ci
npm run build
zip -r delaine-test.zip . -x "node_modules/*" ".git/*" "*.log" "*.tmp"
```

#### Workflow Triggers

-   **Main CI/CD Pipeline**: Runs on push to `main`/`develop` and PRs
-   **Staging Deployment**: Runs on push to `develop` branch
-   **Production Deployment**: Runs on push to `main` branch
-   **Manual Deployment**: Available via GitHub Actions UI

## 📚 Additional Resources

-   [Laravel Documentation](https://laravel.com/docs)
-   [Spatie Laravel Permission](https://spatie.be/docs/laravel-permission)
-   [Tailwind CSS](https://tailwindcss.com/docs)
-   [Docker Documentation](https://docs.docker.com/)

## 🤝 Contributing

1. Fork the repository
2. Create a feature branch (`git checkout -b feature/amazing-feature`)
3. Commit your changes (`git commit -m 'Add amazing feature'`)
4. Push to the branch (`git push origin feature/amazing-feature`)
5. Open a Pull Request

## 📄 License

This project is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).

## 🆘 Support

If you encounter any issues or have questions:

1. Check the [troubleshooting section](#-troubleshooting)
2. Run `php artisan verify:acl` to check your setup
3. Open an issue on GitHub
4. Check existing issues for solutions

---

**Happy coding! 🎉**
