# Gaming Marketplace - Setup Guide

## Quick Start

### 1. Initial Setup
```bash
cd GameTradingMarketplace-main
composer install
npm install
cp .env.example .env
php artisan key:generate
```

### 2. Database Setup
```bash
# Create database (MySQL)
# Update .env with DB credentials first

php artisan migrate
php artisan db:seed
```

### 3. AdminLTE Installation
```bash
npm install admin-lte
npm install bootstrap@5
npm install @popperjs/core
npm run build
```

### 4. Link Storage
```bash
php artisan storage:link
```

### 5. Compile Assets
```bash
npm run dev
# or for production:
npm run build
```

### 6. Start Server
```bash
php artisan serve
```

## Default Credentials
- **Admin**: admin@example.com / password
- **User**: user@example.com / password

## Project Structure
```
app/
├── Http/
│   ├── Controllers/
│   │   ├── Admin/
│   │   ├── User/
│   │   └── Auth/
│   ├── Middleware/
│   └── Requests/
├── Models/
├── Traits/
└── Enums/
database/
├── migrations/
├── seeders/
└── factories/
resources/
├── views/
│   ├── layouts/
│   ├── admin/
│   ├── user/
│   └── auth/
├── css/
└── js/
```

## Key Features
✓ User authentication with roles
✓ AdminLTE dashboard
✓ Item CRUD management
✓ Marketplace with filtering
✓ Trading workflow
✓ Transaction history
✓ Admin panel with statistics
✓ Image uploads
✓ Role-based access control
