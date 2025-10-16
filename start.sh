#!/bin/bash

# Install PHP dependencies if vendor is missing
if [ ! -d "vendor" ]; then
  echo "Installing composer dependencies..."
  composer install
fi

# Install JS dependencies if node_modules is missing
if [ ! -d "node_modules" ]; then
  echo "Installing npm dependencies..."
  npm install
fi

# Generate key if not set
php artisan key:generate --force

# Wait for database to be ready
echo "Waiting for database to be ready..."
for i in {1..30}; do
    if php artisan tinker --execute="DB::connection()->getPdo();" > /dev/null 2>&1; then
        echo "Database is ready!"
        break
    fi
    echo "Attempt $i: Database not ready, waiting 2 seconds..."
    sleep 2
done

# Run migrations
php artisan migrate --force

# Start Laravel in background
php artisan serve --host=0.0.0.0 --port=8000 &

# Start Vite in background
npm run dev -- --host &

# Keep container running
tail -f /dev/null
