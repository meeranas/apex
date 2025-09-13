#!/bin/bash

echo "�� Setting up Apex Dashboard with Laravel Filament..."

# Create a temporary directory for Laravel
echo "📦 Creating temporary Laravel project..."
mkdir -p temp-laravel
cd temp-laravel

# Install Laravel in temp directory
echo "🔧 Installing Laravel..."
docker run --rm -v $(pwd):/app composer create-project laravel/laravel . --prefer-dist

# Move Laravel files to parent directory
echo "📁 Moving Laravel files..."
cp -r * ../
cp -r .* ../ 2>/dev/null || true

# Go back to parent directory
cd ..

# Remove temp directory
rm -rf temp-laravel

# Build and start the containers
echo "🐳 Building Docker containers..."
docker-compose up -d --build

# Wait for MySQL to be ready
echo "⏳ Waiting for MySQL to be ready..."
sleep 30

# Install Filament
echo "🎨 Installing Filament Admin Panel..."
docker-compose exec app composer require filament/filament:"^3.0"

# Install Filament
echo "⚙️ Setting up Filament..."
docker-compose exec app php artisan filament:install --panels

# Generate application key
echo "🔑 Generating application key..."
docker-compose exec app php artisan key:generate

# Run migrations
echo "🗄️ Running database migrations..."
docker-compose exec app php artisan migrate

# Create a sample user
echo "👤 Creating admin user..."
docker-compose exec app php artisan make:filament-user

echo "✅ Setup complete!"
echo ""
echo "🌐 Your application is available at: http://localhost:8080"
echo "🔧 Admin panel: http://localhost:8080/admin"
echo "🗄️ phpMyAdmin: http://localhost:8081"
echo ""
echo "📝 To stop the containers: docker-compose down"
echo "📝 To view logs: docker-compose logs -f"
