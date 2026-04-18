#!/bin/sh
set -e

echo "▶ Caching config & routes..."
php artisan config:cache
php artisan route:cache
php artisan view:cache

echo "▶ Running migrations..."
php artisan migrate --force

echo "▶ Seeding admin user..."
php artisan db:seed --class=AdminUserSeeder --force
php artisan db:seed --class=PortfolioSeeder --force

echo "▶ Linking storage..."
php artisan storage:link || true

echo "▶ Starting server on port 10000..."
php artisan serve --host=0.0.0.0 --port=10000
