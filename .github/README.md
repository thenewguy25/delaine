# GitHub Actions CI/CD

Simple and focused CI/CD pipeline for the Delaine project.

## Workflow

### Main CI/CD Pipeline (`ci.yml`)

**Triggers:**

-   Push to `main` or `develop` branches
-   Pull requests to `main` or `develop` branches

**What it does:**

1. **Tests**: Runs all unit tests with MySQL database
2. **Build**: Compiles frontend assets
3. **Deploy**: Deploys to production (main branch only)

## Setup

1. **Repository Secrets** (if needed for deployment):

    ```
    PRODUCTION_HOST=your-server.com
    PRODUCTION_USER=deploy-user
    PRODUCTION_KEY=your-ssh-private-key
    ```

2. **Environment Variables** (if needed):
    ```
    APP_ENV=production
    ```

## Usage

-   **Automatic**: Tests run on every push and PR
-   **Deployment**: Only deploys from `main` branch
-   **Manual**: Can be triggered manually from GitHub Actions tab

## Customization

To add actual deployment commands, edit the deploy step in `ci.yml`:

```yaml
- name: Deploy to production
  run: |
      # Add your deployment commands here
      # Example:
      # scp -r . user@server:/var/www/
      # ssh user@server "cd /var/www && php artisan migrate --force"
```

## Benefits

-   ✅ **Simple**: One workflow file, easy to understand
-   ✅ **Fast**: Only essential steps, quick feedback
-   ✅ **Reliable**: Focused on core functionality
-   ✅ **Maintainable**: Easy to modify and extend
