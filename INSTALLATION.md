# Gaming Marketplace - Complete Setup & Installation Guide

## Project Overview

This is a complete Laravel 12 gaming item trading marketplace with:
- User authentication with role-based access (Admin/User)
- AdminLTE dashboard layout
- Item CRUD management with image uploads
- Marketplace browsing with filters
- Buy/Trade workflow system
- Transaction history tracking
- Admin panel for system oversight

## 🚀 Quick Start

### Prerequisites
- PHP 8.2+
- Composer
- MySQL/MariaDB
- Node.js & npm

### Step 1: Install Dependencies

```bash
cd GameTradingMarketplace-main

# Install PHP dependencies
composer install

# Install npm dependencies
npm install

# Generate application key
php artisan key:generate

# Create .env file if not exists
cp .env.example .env
```

### Step 2: Configure Environment

Edit `.env` file:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=game_trading_marketplace
DB_USERNAME=root
DB_PASSWORD=

FILESYSTEM_DISK=public
```

### Step 3: Create Database

```bash
# Create MySQL database
mysql -u root -p
> CREATE DATABASE game_trading_marketplace;
> EXIT;

# Run migrations
php artisan migrate

# Seed sample data
php artisan db:seed
```

### Step 4: Setup Storage & Assets

```bash
# Create symbolic link for file storage
php artisan storage:link

# Compile assets
npm run dev
# Or for production:
npm run build
```

### Step 5: Start Development Server

```bash
php artisan serve
```

Visit: http://localhost:8000

## 📝 Default Credentials

### Admin Account
- Email: `admin@example.com`
- Password: `password`

### Test User Accounts
- Email: `user@example.com` | Password: `password`
- Email: `jane@example.com` | Password: `password`

## 🏗️ Project Structure

```
app/
├── Http/
│   ├── Controllers/
│   │   ├── Admin/
│   │   │   ├── DashboardController.php
│   │   │   ├── UserController.php
│   │   │   ├── ItemController.php
│   │   │   └── TransactionController.php
│   │   └── User/
│   │       ├── DashboardController.php
│   │       ├── ItemController.php
│   │       ├── MarketplaceController.php
│   │       ├── TransactionController.php
│   │       └── ProfileController.php
│   ├── Middleware/
│   │   ├── EnsureUserIsAdmin.php
│   │   └── EnsureUserIsUser.php
│   └── Requests/
│       ├── StoreItemRequest.php
│       ├── UpdateItemRequest.php
│       └── StoreTransactionRequest.php
├── Models/
│   ├── User.php
│   ├── Profile.php
│   ├── Item.php
│   └── Transaction.php
└── Traits/

database/
├── migrations/
│   ├── 2024_01_01_000001_create_users_table.php
│   ├── 2024_01_01_000002_create_profiles_table.php
│   ├── 2024_01_01_000003_create_items_table.php
│   └── 2024_01_01_000004_create_transactions_table.php
└── seeders/
    └── DatabaseSeeder.php

resources/
├── views/
│   ├── layouts/
│   │   └── app.blade.php
│   ├── admin/
│   │   ├── dashboard.blade.php
│   │   ├── users/
│   │   ├── items/
│   │   └── transactions/
│   └── user/
│       ├── dashboard.blade.php
│       ├── items/
│       ├── marketplace/
│       ├── transactions/
│       └── profile/
└── css/ & js/

routes/
└── web.php
```

## 📚 Database Schema

### Users Table
- id, name, email, password, role (admin/user), timestamps

### Profiles Table
- id, user_id, username, avatar, bio, phone, address, timestamps

### Items Table
- id, user_id, name, description, image, price, status (available/sold/traded), category, quantity, timestamps

### Transactions Table
- id, item_id, buyer_id, seller_id, offer_item_id (nullable), offer_amount (nullable), total_price, type (buy/trade), status (pending/accepted/rejected/completed/cancelled), notes, accepted_at, rejected_at, completed_at, timestamps

## 🔑 Key Features

### Authentication
- Secure login/registration with validation
- Role-based access control (Admin/User middleware)
- Profile creation on user registration

### User Dashboard
- Statistics: Total items, available items, pending trades, total sales
- Quick action buttons
- Item management links

### Item Management
- Create/Edit/Delete items with image upload
- Set price, category, description
- Track item status (available/sold/traded)
- Full CRUD operations

### Marketplace
- Browse available items from other users
- Search functionality (by name/description)
- Filter by: price range, category, seller
- View detailed item information
- Make trade/purchase offers

### Trading System

#### Buy Workflow:
1. User browses marketplace
2. Selects item and offers amount
3. Seller receives notification
4. Seller accepts/rejects
5. If accepted, marked as completed
6. Item status changes to "sold"

#### Trade Workflow:
1. User selects item to trade for
2. Chooses one of their own available items
3. Sends trade offer with optional message
4. Seller reviews trade offer
5. Seller accepts/rejects
6. If accepted, both items marked as "traded"

### Transaction Management
- View all buy/sell transactions
- Track transaction status
- Accept/Reject pending trades
- Complete accepted trades
- Full transaction history

### Admin Panel
- System statistics dashboard
- Manage all users
- View all items in system
- Monitor all transactions
- Cancel pending trades if needed
- Delete problematic items/users

### User Profile
- Edit profile information (name, username, email)
- Upload avatar
- Add bio, phone, address
- View personal statistics

## 🔒 Security Features

- ✅ CSRF token protection on all forms
- ✅ Role-based middleware (Admin only, User only)
- ✅ Authorization checks (can't buy own items, can't edit others' items)
- ✅ User can only manage their own transactions
- ✅ Admin has full system access
- ✅ File upload validation (images only)
- ✅ Form request validation

## 🧪 Testing the Application

### Create New Item:
1. Login as user
2. Go to "My Items" → "Add New Item"
3. Fill details and upload image
4. Submit

### Browse Marketplace:
1. Go to "Marketplace"
2. Use filters to search items
3. Click "Make an Offer" on any item

### Make a Trade:
1. Select "Trade with Item" option
2. Choose your item to trade
3. Add optional message
4. Submit offer

### Accept Trade (as Seller):
1. Go to "Transaction History" → "Sales"
2. Click on pending offer
3. Click "Accept Offer"

### Complete Trade:
1. As buyer, go to transaction
2. Click "Confirm Completion"
3. Transaction marked as completed

## 🛠️ Common Commands

```bash
# Clear caches
php artisan cache:clear
php artisan config:clear
php artisan view:clear

# Fresh migration (⚠️ Drops all tables)
php artisan migrate:fresh --seed

# Watch assets for development
npm run dev

# Build for production
npm run build

# Create new migration
php artisan make:migration create_table_name

# Create new model
php artisan make:model ModelName

# Create new controller
php artisan make:controller ControllerName
```

## 🐛 Troubleshooting

### Images Not Showing
```bash
php artisan storage:link
```

### Database connection error
- Check `.env` database credentials
- Ensure MySQL is running
- Verify database exists

### Assets not loading
```bash
npm install
npm run dev
```

### Middleware not working
- Check `bootstrap/app.php` middleware registration
- Verify middleware aliases are correct

## 📊 Data Relationships

```
User (1) ──→ (Many) Profile
User (1) ──→ (Many) Items
User (1) ──→ (Many) Transactions (as buyer)
User (1) ──→ (Many) Transactions (as seller)

Item (1) ──→ (Many) Transactions

Transaction → Item (sold item)
Transaction → Item (offered item - nullable)
Transaction → User (buyer)
Transaction → User (seller)
```

## 🎯 Business Logic Auto-Corrections Applied

1. ✅ **Prevented Self-Trading**: Users cannot buy/trade their own items
2. ✅ **Status Management**: Items automatically update status when trades complete
3. ✅ **Transaction Flow**: Pending → Accepted → Completed workflow enforced
4. ✅ **Authorization**: Sellers only can accept/reject; Buyers can complete
5. ✅ **Validation**: Prevent duplicate transactions, invalid amounts
6. ✅ **Item Availability**: Only available items can be traded

## 📞 Support

For issues or questions, refer to Laravel documentation:
- https://laravel.com/docs/12.x
- https://adminlte.io/

---

**Happy Trading! 🎮**
