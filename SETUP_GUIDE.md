# Game Trading Marketplace - Complete Laravel Project

## Project Overview

A comprehensive Laravel-based game item trading marketplace featuring user authentication, role-based access control, item management, and a complete trade workflow with AdminLTE interface.

## Features Implemented

### Core Features
- ✅ User Registration & Login with validation
- ✅ Role-based access (Admin/User)
- ✅ AdminLTE-based responsive interface
- ✅ User profile management (username, bio, avatar)
- ✅ Item CRUD operations with image uploads
- ✅ Marketplace browsing with filters
- ✅ Buy and Trade functionality
- ✅ Transaction history & management
- ✅ Admin dashboard with statistics
- ✅ User management (CRUD by admin)

### Database Models
1. **Users** - Authentication with role enum (admin/user)
2. **Profiles** - User profile data (username, bio, avatar)
3. **Items** - Game items with status (available/sold/traded)
4. **Transactions** - Complete transaction tracking
   - Support for both Buy and Trade types
   - Track offer items or offer amounts
   - Status: pending, accepted, rejected, completed

### Security Features
- ✅ Users cannot buy/trade their own items
- ✅ Only sellers can accept/reject trades
- ✅ Admin-only endpoints secured with middleware
- ✅ Authorization policies for items and transactions
- ✅ CSRF protection on all forms
- ✅ Password hashing with Laravel's Hash facade

## Installation & Setup

### 1. Prerequisites
- PHP 8.1+
- Composer
- Node.js & npm
- PostgreSQL/MySQL
- Laravel 11.x

### 2. Environment Setup

```bash
cd d:\WorkshopFramework\GameTradingMarketplace

# Copy environment file
copy .env.example .env

# Generate application key
php artisan key:generate

# Configure .env database credentials
# DB_CONNECTION=pgsql
# DB_HOST=127.0.0.1
# DB_PORT=5432
# DB_DATABASE=game_trading
# DB_USERNAME=postgres
# DB_PASSWORD=your_password
```

### 3. Run Migrations & Seeds

```bash
# Run all migrations and seed database
php artisan migrate:fresh --seed

# Or separately:
php artisan migrate
php artisan db:seed
```

### 4. Default Credentials

After seeding, use these accounts:

**Admin Account:**
- Email: admin@example.com
- Password: password123
- Role: admin

**User Accounts:**
- Email: user1@example.com
- Password: password123
- Role: user

- Email: user2@example.com
- Password: password123
- Role: user

### 5. Start Development Server

```bash
# Start Laravel server
php artisan serve

# In another terminal, start Vite (for frontend assets)
npm run dev
```

Access the application at: `http://localhost:8000`

## Project Structure

```
GameTradingMarketplace/
├── app/
│   ├── Models/
│   │   ├── User.php              # User model with roles & relationships
│   │   ├── Item.php              # Item model
│   │   ├── Profile.php           # User profile data
│   │   └── Transaction.php       # Transaction model
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── DashboardController.php
│   │   │   ├── ItemController.php
│   │   │   ├── TransactionController.php
│   │   │   ├── UserController.php
│   │   │   └── ProfileController.php
│   │   ├── Middleware/
│   │   │   ├── AdminMiddleware.php
│   │   │   └── RoleMiddleware.php
│   │   ├── Requests/
│   │   │   └── ItemRequest.php
│   │   └── Kernel.php
│   ├── Policies/
│   │   ├── ItemPolicy.php
│   │   └── TransactionPolicy.php
│   └── ...
├── database/
│   ├── migrations/
│   │   ├── 0001_01_01_000000_create_users_table.php
│   │   ├── 2025_11_24_000001_add_role_to_users_table.php
│   │   ├── 2025_11_24_000002_create_profiles_table.php
│   │   ├── 2025_11_24_000003_create_items_table.php
│   │   └── 2025_11_24_000004_create_transactions_table.php
│   └── seeders/
│       ├── DatabaseSeeder.php
│       ├── AdminUserSeeder.php
│       ├── ItemSeeder.php
│       └── RoleSeeder.php
├── resources/
│   ├── views/
│   │   ├── layouts/
│   │   │   ├── main.blade.php            # AdminLTE main layout
│   │   │   └── ...
│   │   ├── user/
│   │   │   └── dashboard.blade.php
│   │   ├── admin/
│   │   │   ├── dashboard.blade.php
│   │   │   └── users/
│   │   │       ├── index.blade.php
│   │   │       ├── create.blade.php
│   │   │       ├── edit.blade.php
│   │   │       └── show.blade.php
│   │   ├── marketplace/
│   │   │   └── index.blade.php
│   │   ├── items/
│   │   │   ├── create.blade.php
│   │   │   ├── edit.blade.php
│   │   │   └── show.blade.php
│   │   └── transactions/
│   │       ├── index.blade.php
│   │       └── show.blade.php
│   └── css/js/...
├── routes/
│   ├── web.php                   # Main web routes
│   └── auth.php
└── ...
```

## Routes Overview

### Public Routes
- `GET /` - Welcome page
- `GET /marketplace` - Browse items
- `GET /items/{item}` - View item details

### Authentication Required
- `GET /dashboard` - User dashboard (adaptive based on role)
- `GET /profile` - Edit profile
- `PATCH /profile` - Update profile
- `DELETE /profile` - Delete profile

### Item Management (Authenticated Users)
- `GET /items/create` - Create item form
- `POST /items` - Store item
- `GET /items/{item}/edit` - Edit item form
- `PUT /items/{item}` - Update item
- `DELETE /items/{item}` - Delete item

### Trading & Transactions (Authenticated Users)
- `GET /transactions` - View transaction history
- `GET /transactions/{transaction}` - View transaction details
- `POST /items/{item}/buy` - Initiate buy request
- `POST /items/{item}/trade` - Initiate trade offer
- `POST /transactions/{transaction}/accept` - Accept trade (seller only)
- `POST /transactions/{transaction}/reject` - Reject trade (seller only)
- `POST /transactions/{transaction}/complete` - Complete transaction

### Admin Routes (Admin Only)
- `GET /admin/dashboard` - Admin statistics & overview
- `GET /admin/users` - List all users
- `GET /admin/users/create` - Create user form
- `POST /admin/users` - Store user
- `GET /admin/users/{user}` - View user details
- `GET /admin/users/{user}/edit` - Edit user form
- `PUT /admin/users/{user}` - Update user
- `DELETE /admin/users/{user}` - Delete user

## Workflow Walkthrough

### Item Listing
1. User logs in → Dashboard
2. Click "Add Item" → Create Item Form
3. Upload image, fill details → Create
4. Item appears on Marketplace with status "available"

### Buying an Item
1. Browse Marketplace → Click Item
2. Click "Buy Now"
3. Transaction created with status "pending"
4. Seller reviews → Accepts
5. Transaction marked as completed

### Trading Items
1. Browse Marketplace → Click Item
2. Click "Trade"
3. Select from your items OR offer amount
4. Seller receives trade offer
5. If accepted, both items marked as "traded"
6. Transaction completed

### Admin Management
1. Login as admin → "Admin Dashboard"
2. View statistics (users, items, transactions)
3. Manage users (CRUD)
4. Monitor all marketplace activity

## Database Schema

### users
```sql
- id (primary key)
- name
- email (unique)
- password
- role (enum: 'admin', 'user')
- created_at, updated_at
```

### profiles
```sql
- id (primary key)
- user_id (foreign key)
- username
- avatar
- bio
- created_at, updated_at
```

### items
```sql
- id (primary key)
- user_id (foreign key)
- name
- description
- image
- price (decimal)
- status (enum: 'available', 'sold', 'traded')
- created_at, updated_at
```

### transactions
```sql
- id (primary key)
- buyer_id (foreign key)
- seller_id (foreign key)
- item_id (foreign key)
- offer_item_id (foreign key, nullable)
- offer_amount (decimal, nullable)
- total_price (decimal, nullable)
- type (enum: 'buy', 'trade')
- status (enum: 'pending', 'accepted', 'rejected', 'completed', 'cancelled')
- created_at, updated_at
```

## Key Implementation Details

### Auto-Corrections Applied

1. **Role Management**: Changed from many-to-many role table to simple enum field in users table
   - Simpler, more efficient, prevents over-engineering
   
2. **Item Status Tracking**: Automatically updated when transactions complete
   - Item moves to 'sold' or 'traded' based on transaction type
   
3. **Trade Logic**: Made mutually exclusive
   - User must choose either an item OR an amount, not both
   - Validated on both frontend and backend

4. **Security Enforced**:
   - Users cannot trade with themselves (checked in controller)
   - Only sellers can accept/reject (policy authorization)
   - Admin-only routes protected with middleware

5. **Image Handling**: Standardized field name
   - Uses 'image' field instead of 'image_path'
   - Automatic cleanup on update

### Validation Rules

**Items:**
- Name: required, string, max 255
- Description: required, string, max 1000
- Price: required, numeric, min 0
- Image: required on create, optional on update, max 5MB

**Users (Admin)**:
- Name: required, string, max 255
- Email: required, email, unique
- Password: required, min 8, confirmed
- Role: required, in: admin|user

**Transactions**:
- Either offer_item_id OR offer_amount (not both)
- Both must be valid and belong to authorized users

## API Responses

### Transaction States
```
pending   → Awaiting seller response
accepted  → Seller agreed, ready to complete
rejected  → Seller declined
completed → Transaction finished
cancelled → User cancelled
```

### Item Status
```
available → Can be bought/traded
sold      → Bought by someone
traded    → Traded with another item
```

## Frontend Features

### AdminLTE Integration
- Responsive sidebar navigation
- Color-coded status badges
- Card-based layout
- Mobile-friendly design
- Bootstrap 4 components
- FontAwesome icons

### Interactive Elements
- Image preview on upload
- Trade offer modal dialog
- Confirmation dialogs for deletion
- Filter & search on marketplace
- Real-time status updates
- Pagination for large datasets

## Testing the Application

### Test User Flow
1. Register a new account
2. Login with credentials
3. Create an item with image
4. Browse marketplace
5. Initiate trade with another user
6. Accept/reject trades
7. View transaction history

### Test Admin Flow
1. Login as admin@example.com
2. Access admin dashboard
3. Create new user
4. Edit user details
5. Monitor all transactions
6. View user statistics

## Common Issues & Fixes

### Issue: Image not uploading
**Fix**: Ensure storage directory is writable and symlink is created:
```bash
php artisan storage:link
chmod -R 775 storage/
```

### Issue: Database connection error
**Fix**: Verify .env credentials and database exists:
```bash
php artisan migrate:fresh --seed
```

### Issue: Middleware not working
**Fix**: Ensure routes are using middleware:
```php
// In routes/web.php
Route::middleware('admin')->group(...)
```

## Performance Optimizations

- Model relationships eager loaded to prevent N+1 queries
- Pagination on large datasets (users, transactions, items)
- Indexed foreign keys for faster queries
- Image optimization on upload
- CSS/JS minification in production

## Future Enhancements

- Real-time notifications for trades
- User rating/review system
- Item wishlists
- Price history/trends
- Email notifications
- Payment gateway integration
- Two-factor authentication
- Dispute resolution system
- API endpoints for mobile app

## Support

For issues or questions:
1. Check Laravel documentation: laravel.com
2. Review AdminLTE docs: adminlte.io
3. Check migration files for schema details
4. Use tinker for quick testing: `php artisan tinker`

## License

This project is part of the Workshop Framework training series.
