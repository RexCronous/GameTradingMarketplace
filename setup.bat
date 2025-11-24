@echo off
REM Quick Setup Script for Game Trading Marketplace (Windows)

echo.
echo 🎮 Game Trading Marketplace - Setup Script
echo ===========================================
echo.

REM Check if .env exists
if not exist .env (
    echo 📝 Creating .env file...
    copy .env.example .env
)

REM Install dependencies
echo 📦 Installing PHP dependencies...
call composer install

echo 📦 Installing NPM dependencies...
call npm install

REM Generate key
echo 🔑 Generating application key...
call php artisan key:generate

REM Setup database
echo.
echo 🗄️  Setting up database...
echo ⚠️  Make sure MySQL is running and database credentials are set in .env
echo.
pause

call php artisan migrate

REM Seed sample data
echo.
echo 🌱 Seeding sample data...
call php artisan db:seed

REM Link storage
echo.
echo 📁 Linking storage...
call php artisan storage:link

REM Compile assets
echo.
echo 🎨 Compiling assets...
call npm run dev

echo.
echo ✅ Setup complete!
echo.
echo 🚀 Start development server with:
echo    php artisan serve
echo.
echo 📊 Access the application at:
echo    http://localhost:8000
echo.
echo 👤 Default Credentials:
echo    Admin: admin@example.com / password
echo    User: user@example.com / password
echo.
pause
