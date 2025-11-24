# Game Trading Marketplace - Setup Guide

## Quick Start (5 Minutes)

### 1. Install Dependencies
```bash
composer install
npm install
```

### 2. Configure Environment
The `.env` file has been updated to use SQLite (no PostgreSQL needed):
```
DB_CONNECTION=sqlite
```

### 3. Generate App Key
```bash
php artisan key:generate
```

### 4. Setup Database
```bash
php artisan migrate --seed
```

### 5. Run Dev Server
```bash
php artisan serve
```

Visit: http://127.0.0.1:8000

---

## Default Credentials

**Admin Account:**
- Email: `admin@example.com`
- Password: `password`

**Test User Account:**
- Email: `user@example.com`
- Password: `password`

---

## Features Implemented

✅ User Authentication (Register/Login)
✅ Role-Based Access (Admin/User)
✅ AdminLTE Layout (All Pages)
✅ Item Management (CRUD)
✅ Marketplace Browsing
✅ Trading System (Buy/Trade Offers)
✅ Transaction History
✅ Admin Dashboard
✅ User Profile Management
✅ Image Upload Support
✅ Secure Authorization Checks

---

## Project Structure

```
app/
  ├── Http/
  │   ├── Controllers/
  │   │   ├── ItemController.php
  │   │   ├── TransactionController.php
  │   │   ├── ProfileController.php
  │   │   ├── AdminController.php
  │   │   └── MarketplaceController.php
  │   ├── Middleware/
  │   │   ├── EnsureAdminRole.php
  │   │   └── EnsureUserRole.php
  │   └── Requests/
  │       ├── StoreItemRequest.php
  │       └── StoreTransactionRequest.php
  │
  ├── Models/
  │   ├── User.php
  │   ├── Item.php
  │   ├── Profile.php
  │   ├── Transaction.php
  │   └── Role.php
  │
database/
  ├── migrations/
  │   ├── create_users_table
  │   ├── create_profiles_table
  │   ├── create_items_table
  │   └── create_transactions_table
  │
  └── seeders/
      ├── DatabaseSeeder.php
      ├── RoleSeeder.php
      └── UserSeeder.php

resources/
  └── views/
      ├── layouts/
      │   ├── app.blade.php (AdminLTE)
      │   ├── sidebar.blade.php
      │   ├── navbar.blade.php
      │   └── footer.blade.php
      │
      ├── dashboard/
      │   ├── admin.blade.php
      │   └── user.blade.php
      │
      ├── items/
      │   ├── index.blade.php
      │   ├── create.blade.php
      │   ├── edit.blade.php
      │   └── show.blade.php
      │
      ├── marketplace/
      │   ├── index.blade.php
      │   ├── show.blade.php
      │   └── trade-modal.blade.php
      │
      ├── transactions/
      │   ├── index.blade.php
      │   ├── show.blade.php
      │   └── offers.blade.php
      │
      └── profile/
          ├── edit.blade.php
          └── show.blade.php
```

---

## Key Files Modified

1. **database/migrations/0001_01_01_000000_create_users_table.php**
   - Added `role` enum column (admin/user)

2. **database/migrations/2024_01_01_000001_create_profiles_table.php**
   - User profile management

3. **database/migrations/2024_01_01_000002_create_items_table.php**
   - Item listing with image support

4. **database/migrations/2024_01_01_000003_create_transactions_table.php**
   - Complete transaction schema (buy/trade)

5. **app/Models/User.php**
   - Added role-based methods
   - Relationships: profile, items, transactions

6. **app/Models/Item.php**
   - Image URL helper
   - Status helpers

7. **app/Models/Transaction.php**
   - Accept/reject logic
   - Status helpers
   - Trading logic

8. **app/Http/Middleware/EnsureAdminRole.php**
   - Admin-only route protection

---

## Troubleshooting

### Database Error?
Make sure SQLite file exists:
```bash
touch database/database.sqlite
php artisan migrate
```

### Storage/Images Not Working?
```bash
php artisan storage:link
```

### Cache Issues?
```bash
php artisan config:cache
php artisan view:cache
php artisan route:cache
```

---

## Next Steps

1. Run `php artisan serve`
2. Visit http://127.0.0.1:8000
3. Login as admin@example.com / password
4. Explore Admin Dashboard
5. Create test items and offers

---

## Support

All files have been corrected for:
- Proper relationships
- Secure authorization
- Consistent database schema
- Complete trading workflow
- AdminLTE integration

Enjoy your Trading Marketplace! 🚀
