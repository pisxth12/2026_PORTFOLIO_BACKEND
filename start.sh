#!/bin/sh
set -e

echo "▶ Creating session table..."
php artisan session:table || true

echo "▶ Running migrations..."
php artisan migrate --force

echo "▶ Seeding..."
php artisan db:seed --class=AdminUserSeeder --force
php artisan db:seed --class=PortfolioSeeder --force

echo "▶ Caching..."
php artisan config:cache
php artisan route:cache
php artisan view:cache

echo "▶ Publishing Filament assets..."
php artisan filament:assets

echo "▶ Linking storage..."
php artisan storage:link || true

echo "▶ Starting server..."
php artisan serve --host=0.0.0.0 --port=10000
