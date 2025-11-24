# Quick Start Guide - Game Trading Marketplace

## 🚀 Fast Setup (5 minutes)

### Step 1: Navigate to Project
```bash
cd d:\WorkshopFramework\GameTradingMarketplace
```

### Step 2: Install & Configure
```bash
# Dependencies
composer install
npm install

# Environment
copy .env.example .env
php artisan key:generate

# Configure .env with your database credentials
# (Database must be created first)
```

### Step 3: Database Setup
```bash
# Fresh database with sample data
php artisan migrate:fresh --seed

# Create storage link for images
php artisan storage:link
```

### Step 4: Run Server
```bash
# Terminal 1 - Laravel server
php artisan serve

# Terminal 2 - Frontend assets (optional for Vite)
npm run dev
```

## 🔐 Login Credentials

| Role | Email | Password |
|------|-------|----------|
| Admin | admin@example.com | password123 |
| User 1 | user1@example.com | password123 |
| User 2 | user2@example.com | password123 |

## 🎮 Sample Data

After seeding, you'll have:
- **3 Users** (1 admin + 2 regular users)
- **4 Sample Items** (ready to trade)
- **Sample Profiles** with usernames and bios

## 📍 Navigation

### For Regular Users
1. Visit `http://localhost:8000`
2. Click Login
3. Use user credentials
4. Dashboard shows your items and pending trades
5. "Marketplace" to browse other items
6. Click item → "Buy Now" or "Trade"

### For Admins
1. Login as admin
2. Access `/admin/dashboard`
3. View statistics
4. Manage users in "Manage Users"
5. Monitor all transactions

## 📋 Key Features to Test

### Item Management
- ✅ Create new item (Dashboard → "Add Item")
- ✅ Upload item image
- ✅ Edit item details
- ✅ Delete item (only if available)
- ✅ Browse marketplace with filters

### Trading
- ✅ Buy item from marketplace
- ✅ Propose trade with your item
- ✅ Propose trade with money offer
- ✅ Accept/reject trades as seller
- ✅ View transaction history

### Admin Features
- ✅ View all users and their stats
- ✅ Create new user
- ✅ Edit user role or password
- ✅ Delete user
- ✅ Monitor marketplace activity

## 🗂️ Important Directories

```
GameTradingMarketplace/
├── app/Models/          ← Database models
├── app/Http/
│   ├── Controllers/     ← Business logic
│   ├── Middleware/      ← Access control
│   └── Requests/        ← Form validation
├── database/
│   ├── migrations/      ← Database schema
│   └── seeders/         ← Sample data
├── resources/views/     ← UI templates (AdminLTE)
└── routes/web.php       ← All routes
```

## 💾 Database Schema

### User Role Enum
```
'admin' → Full system access
'user'  → Limited marketplace access
```

### Item Status Enum
```
'available' → Can be bought/traded
'sold'      → Purchased
'traded'    → Exchanged with another item
```

### Transaction Status
```
'pending'    → Awaiting seller response
'accepted'   → Seller approved
'rejected'   → Seller declined
'completed'  → Trade finished
'cancelled'  → User cancelled
```

### Transaction Type
```
'buy'   → Direct purchase
'trade' → Item/money exchange
```

## 🔍 Troubleshooting

| Issue | Solution |
|-------|----------|
| Database error | Check .env, create DB, run `php artisan migrate:fresh --seed` |
| Image not showing | Run `php artisan storage:link` |
| Routes not working | Run `php artisan route:cache --clear` |
| Permission denied | Check storage folder permissions: `chmod -R 755 storage` |
| Style/JS not loading | Run `npm run dev` in separate terminal |

## 🎯 Test Scenarios

### Scenario 1: Complete a Buy Transaction
1. Login as User 1
2. Go to Marketplace
3. Find User 2's "Dragon Scale Armor"
4. Click "Buy Now"
5. Logout, Login as User 2
6. Go to Transactions
7. Accept the buy request
8. Item status changes to "sold"

### Scenario 2: Trade Items
1. Login as User 1
2. Go to Marketplace
3. Find User 2's item
4. Click "Trade"
5. Select "Legendary Sword" from your items
6. Send offer
7. Logout, Login as User 2
8. Accept trade
9. Both items marked as "traded"

### Scenario 3: Admin Monitoring
1. Login as Admin
2. View Admin Dashboard
3. See statistics
4. Manage users
5. Create new test user
6. Edit user role
7. Delete test user

## 📚 Documentation Files

- **SETUP_GUIDE.md** - Detailed installation & features
- **IMPLEMENTATION_SUMMARY.md** - Complete checklist & stats
- **README.md** - Laravel default documentation

## 🔗 Quick Links

- Homepage: `http://localhost:8000/`
- Dashboard: `http://localhost:8000/dashboard`
- Marketplace: `http://localhost:8000/marketplace`
- Admin: `http://localhost:8000/admin/dashboard`
- Profile: `http://localhost:8000/profile`

## ⚙️ Useful Commands

```bash
# Clear all caches
php artisan cache:clear
php artisan config:clear
php artisan route:clear

# Reset database
php artisan migrate:fresh --seed

# View all routes
php artisan route:list

# Run tinker (REPL)
php artisan tinker

# Check database
php artisan tinker
>>> User::count()
>>> Item::count()
>>> Transaction::count()
```

## 🎨 Frontend Tech Stack

- **CSS Framework**: Bootstrap 4
- **UI Theme**: AdminLTE 3
- **Icons**: FontAwesome 6
- **Build Tool**: Vite (optional)
- **Template Engine**: Blade

## 🔐 Security Features

✅ CSRF protection on all forms
✅ Password hashing with bcrypt
✅ Role-based middleware
✅ Authorization policies
✅ Input validation
✅ Secure file upload
✅ SQL injection prevention (Eloquent ORM)

## 📞 Support

For issues:
1. Check error logs: `storage/logs/laravel.log`
2. Use `php artisan tinker` to inspect data
3. Review SETUP_GUIDE.md for detailed info
4. Check database migrations for schema

## ✨ Next Steps

After getting comfortable:
1. Explore the code structure
2. Add new features (ratings, notifications)
3. Integrate payment gateway
4. Deploy to production
5. Add automated tests

---

**Version**: 1.0 (Complete Implementation)
**Last Updated**: November 24, 2025
**Status**: Ready for Production
