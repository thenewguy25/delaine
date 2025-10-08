# GitHub Actions Workflows

This directory contains GitHub Actions workflows for CI/CD automation of the Delaine project.

## 📋 Available Workflows

### 1. **CI/CD Pipeline** (`ci.yml`)

**Triggers:** Push to `main`/`develop`, Pull Requests

**Jobs:**

-   **Test**: Runs unit tests with MySQL service
-   **Build Assets**: Builds frontend assets
-   **Code Quality**: PHP CS Fixer, PHPStan, dependency audit
-   **Docker Build**: Tests Docker image build
-   **Deploy Staging**: Auto-deploy to staging on `develop` branch
-   **Deploy Production**: Auto-deploy to production on `main` branch
-   **Notify**: Team notifications

### 2. **Pull Request Checks** (`pr-checks.yml`)

**Triggers:** Pull Requests to `main`/`develop`

**Features:**

-   Quick unit test execution
-   Frontend asset building
-   Security vulnerability checks
-   Automatic PR comments with test results

### 3. **Deploy** (`deploy.yml`)

**Triggers:** Push to `main`, Manual dispatch

**Features:**

-   Environment-specific deployments (staging/production)
-   Pre-deployment backups
-   Post-deployment health checks
-   Automatic rollback on failure

### 4. **Test Suite** (`test.yml`)

**Triggers:** Manual dispatch only

**Features:**

-   On-demand test execution
-   Configurable test suites (Unit/Feature/All)
-   Optional verbose output and coverage reports
-   Manual trigger for debugging

## 🚀 Quick Start

### Running Tests Locally

```bash
# Run all unit tests
php artisan test --testsuite=Unit

# Run with coverage
php artisan test --testsuite=Unit --coverage

# Run specific test file
php artisan test tests/Unit/UserTest.php
```

### Manual Workflow Triggers

1. **Run Tests**: Go to Actions → Test Suite → Run workflow
2. **Deploy**: Go to Actions → Deploy → Run workflow (select environment)

## 🔧 Configuration

### Environment Variables

Set these in your repository secrets:

**For Deployment:**

-   `STAGING_HOST`: Staging server hostname
-   `STAGING_USER`: Staging server username
-   `STAGING_KEY`: SSH private key for staging
-   `PRODUCTION_HOST`: Production server hostname
-   `PRODUCTION_USER`: Production server username
-   `PRODUCTION_KEY`: SSH private key for production

**For Notifications:**

-   `SLACK_WEBHOOK`: Slack webhook URL (optional)
-   `DISCORD_WEBHOOK`: Discord webhook URL (optional)

### Database Configuration

The workflows use MySQL 8.0 service with these defaults:

-   **Host**: 127.0.0.1
-   **Port**: 3306
-   **Database**: delaine_test
-   **Username**: root
-   **Password**: password

## 📊 Test Coverage

The CI pipeline generates test coverage reports:

-   **Unit Tests**: 64 tests covering core functionality
-   **Coverage**: Uploaded to Codecov for tracking
-   **Reports**: Available in workflow artifacts

## 🔄 Deployment Process

### Staging Deployment

1. Push to `develop` branch
2. Tests run automatically
3. On success, deploys to staging
4. Post-deployment health checks

### Production Deployment

1. Push to `main` branch
2. Full test suite runs
3. Backup created
4. Production deployment
5. Health checks and rollback on failure

## 📈 Monitoring

### Workflow Status

-   **Green**: All checks passed
-   **Yellow**: Some checks failed (non-blocking)
-   **Red**: Critical checks failed (blocking)

### Notifications

-   **Success**: Team notification on successful deployment
-   **Failure**: Alert on failed tests or deployments
-   **PR Comments**: Automatic test result comments

## 🐛 Troubleshooting

### Common Issues

**Test Failures:**

```bash
# Check test database connection
php artisan migrate --env=testing

# Clear test cache
php artisan config:clear --env=testing
```

**Deployment Failures:**

-   Check SSH key permissions
-   Verify server connectivity
-   Review deployment logs

**Security Scan Issues:**

-   Update dependencies: `composer update`
-   Review vulnerability reports
-   Update Docker base images

### Debug Mode

Enable debug output by adding `--verbose` to workflow steps or using the manual test workflow with verbose option.

## 📚 Additional Resources

-   [GitHub Actions Documentation](https://docs.github.com/en/actions)
-   [Laravel Testing Guide](https://laravel.com/docs/testing)
-   [PHPStan Documentation](https://phpstan.org/user-guide/getting-started)
-   [Trivy Security Scanner](https://trivy.dev/)

---

**Need help?** Check the workflow logs or create an issue for workflow-specific problems.
