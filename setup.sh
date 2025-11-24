#!/bin/bash
# Quick Setup Script for Game Trading Marketplace

echo "🎮 Game Trading Marketplace - Setup Script"
echo "==========================================="
echo ""

# Check if .env exists
if [ ! -f .env ]; then
    echo "📝 Creating .env file..."
    cp .env.example .env
fi

# Install dependencies
echo "📦 Installing PHP dependencies..."
composer install

echo "📦 Installing NPM dependencies..."
npm install

# Generate key
echo "🔑 Generating application key..."
php artisan key:generate

# Setup database
echo ""
echo "🗄️  Setting up database..."
echo "⚠️  Make sure MySQL is running and database credentials are set in .env"
echo ""
read -p "Press Enter to continue with migrations..."

php artisan migrate

# Seed sample data
echo ""
echo "🌱 Seeding sample data..."
php artisan db:seed

# Link storage
echo ""
echo "📁 Linking storage..."
php artisan storage:link

# Compile assets
echo ""
echo "🎨 Compiling assets..."
npm run dev

echo ""
echo "✅ Setup complete!"
echo ""
echo "🚀 Start development server with:"
echo "   php artisan serve"
echo ""
echo "📊 Access the application at:"
echo "   http://localhost:8000"
echo ""
echo "👤 Default Credentials:"
echo "   Admin: admin@example.com / password"
echo "   User: user@example.com / password"
echo ""
