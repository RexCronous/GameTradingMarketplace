# GameTradingMarketplace

Short instructions to configure and run the project locally with PostgreSQL.

Prerequisites
- PHP 8.2+ with `pdo_pgsql` extension enabled
- Composer
- PostgreSQL server

Quick setup (Windows PowerShell)

1. Copy environment file and edit DB values (or use DB_URL):
```powershell
cd 'C:\laragon\www\GameTradingMarketplace-main'
copy .env.example .env
# edit .env to set DB_USERNAME, DB_PASSWORD, DB_DATABASE (or DB_URL)
```

2. Install dependencies and create storage link:
```powershell
composer install
php artisan storage:link
```

3. Prepare PostgreSQL database and run migrations + seeders:
```powershell
# create database (example using psql):
# psql -U postgres -c "CREATE DATABASE gametradingmarket;"
php artisan migrate
php artisan db:seed
```

4. Run the app:
```powershell
php artisan serve
```

Notes
- Ensure `pdo_pgsql` (and `pgsql`) PHP extensions are enabled in your PHP installation.
- Default seeders create roles `admin` and `user`, an admin account `admin@example.com` with password `password`, and a `test@example.com` user.

