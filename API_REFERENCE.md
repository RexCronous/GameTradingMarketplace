# API & Routes Reference

## Authentication Routes
```
POST    /login              - User login
POST    /register           - User registration  
POST    /logout             - User logout
GET     /forgot-password    - Password reset request
POST    /reset-password     - Password reset confirm
```

## User Dashboard Routes
```
GET     /dashboard          - User dashboard home
```

## User Item Management Routes
```
GET     /items              - List user's items (user.items.index)
GET     /items/create       - Create item form (user.items.create)
POST    /items              - Store new item (user.items.store)
GET     /items/{item}/edit  - Edit item form (user.items.edit)
PUT     /items/{item}       - Update item (user.items.update)
DELETE  /items/{item}       - Delete item (user.items.destroy)
```

## Marketplace Routes
```
GET     /marketplace                - Browse marketplace (user.marketplace.index)
GET     /marketplace/{item}         - View item details (user.marketplace.show)
GET     /marketplace?search=...     - Search items
GET     /marketplace?category=...   - Filter by category
GET     /marketplace?min_price=...  - Filter by price range
GET     /marketplace?max_price=...
```

## User Transaction Routes
```
GET     /transactions               - View all transactions (user.transactions.index)
GET     /transactions/{transaction} - View transaction details (user.transactions.show)
GET     /transactions/item/{item}/create - Create trade form (user.transactions.create)
POST    /transactions/item/{item}   - Submit trade (user.transactions.store)
POST    /transactions/{transaction}/accept - Accept trade (user.transactions.accept)
POST    /transactions/{transaction}/reject - Reject trade (user.transactions.reject)
POST    /transactions/{transaction}/complete - Complete trade (user.transactions.complete)
```

## User Profile Routes
```
GET     /profile/edit               - Edit profile form (user.profile.edit)
POST    /profile/update             - Save profile (user.profile.update)
```

## Admin Dashboard Routes
```
GET     /admin/dashboard            - Admin dashboard (admin.dashboard)
```

## Admin User Management Routes
```
GET     /admin/users                - List users (admin.users.index)
GET     /admin/users/{user}         - View user details (admin.users.show)
DELETE  /admin/users/{user}         - Delete user (admin.users.destroy)
```

## Admin Item Management Routes
```
GET     /admin/items                - List all items (admin.items.index)
GET     /admin/items/{item}         - View item details (admin.items.show)
DELETE  /admin/items/{item}         - Delete item (admin.items.destroy)
```

## Admin Transaction Management Routes
```
GET     /admin/transactions             - List all transactions (admin.transactions.index)
GET     /admin/transactions/{transaction} - View transaction (admin.transactions.show)
POST    /admin/transactions/{transaction}/cancel - Cancel transaction (admin.transactions.cancel)
```

---

## Controller Methods Reference

### Admin/DashboardController
```
index() - Display admin dashboard with statistics
```

### Admin/UserController
```
index() - List all users with pagination
show(User $user) - Show user details with stats
destroy(User $user) - Delete user account
```

### Admin/ItemController
```
index() - List all items in system
show(Item $item) - View item details
destroy(Item $item) - Delete item
```

### Admin/TransactionController
```
index() - List all transactions
show(Transaction $transaction) - View transaction details
cancel(Transaction $transaction) - Cancel pending transaction
```

### User/DashboardController
```
index() - Display user dashboard with personal stats
```

### User/ItemController
```
index() - List user's items
create() - Show create item form
store(StoreItemRequest $request) - Create new item
edit(Item $item) - Show edit form
update(UpdateItemRequest $request, Item $item) - Update item
destroy(Item $item) - Delete item
```

### User/MarketplaceController
```
index(Request $request) - Browse marketplace with filters
show(Item $item) - View item details for purchase/trade
```

### User/TransactionController
```
index() - View user's transactions (buy & sell)
show(Transaction $transaction) - View transaction details
create(Item $item) - Show make offer form
store(StoreTransactionRequest $request, Item $item) - Submit offer
accept(Transaction $transaction) - Accept offer (seller only)
reject(Transaction $transaction) - Reject offer (seller only)
complete(Transaction $transaction) - Complete trade
```

### User/ProfileController
```
edit() - Show edit profile form
update(Request $request) - Update profile
```

---

## Model Methods

### User Model
```
profile() → HasOne Profile
items() → HasMany Item
buyerTransactions() → HasMany Transaction
sellerTransactions() → HasMany Transaction

isAdmin() → bool
isUser() → bool
canEditItem(Item $item) → bool
canDeleteItem(Item $item) → bool
canBuyItem(Item $item) → bool
getAvatarUrl() → string
getStatistics() → array
```

### Profile Model
```
user() → BelongsTo User
getAvatarUrl() → string
```

### Item Model
```
user() → BelongsTo User
transactions() → HasMany Transaction

isAvailable() → bool
isSold() → bool
isTraded() → bool
canBeTraded() → bool
getImageUrl() → string
markAsSold() → bool
markAsTraded() → bool
markAsAvailable() → bool
```

### Transaction Model
```
item() → BelongsTo Item
buyer() → BelongsTo User
seller() → BelongsTo User
offerItem() → BelongsTo Item [nullable]

isPending() → bool
isAccepted() → bool
isRejected() → bool
isCompleted() → bool
isCancelled() → bool
isBuyType() → bool
isTradeType() → bool
canBeAccepted() → bool
canBeRejected() → bool
accept() → bool
reject() → bool
complete() → bool
cancel() → bool
```

---

## Query Examples

### Find items by seller
```php
Item::where('user_id', $userId)->get();
```

### Get pending transactions for user
```php
Transaction::where('buyer_id', $userId)
    ->where('status', 'pending')
    ->get();
```

### Get completed sales
```php
Transaction::where('seller_id', $userId)
    ->where('status', 'completed')
    ->where('type', 'buy')
    ->sum('total_price');
```

### Find available items excluding user's
```php
Item::where('status', 'available')
    ->where('user_id', '!=', $userId)
    ->get();
```

### Search items
```php
Item::where('name', 'LIKE', "%$search%")
    ->orWhere('description', 'LIKE', "%$search%")
    ->get();
```

---

## Middleware

### EnsureUserIsAdmin
Redirects to 403 if user is not admin
```
Route::middleware('admin')->group(...)
```

### EnsureUserIsUser
Redirects to 403 if user is not regular user
```
Route::middleware('user')->group(...)
```

### auth
Built-in Laravel middleware, ensures user is logged in
```
Route::middleware('auth')->group(...)
```

---

## HTTP Status Codes Used

- 200 - Successful GET/POST request
- 201 - Resource created (POST)
- 204 - No content (DELETE)
- 302 - Redirect (POST with redirect)
- 400 - Bad request (validation errors)
- 403 - Forbidden (authorization denied)
- 404 - Not found
- 422 - Unprocessable entity (validation failed)
- 500 - Server error

---

## Request/Response Examples

### Create Item
**Request:**
```
POST /items
Content-Type: multipart/form-data

name=Legendary Sword
description=Powerful sword
price=500
category=Weapon
quantity=1
image=[FILE]
```

**Response:**
```
Redirect to /items with success message
```

### Make Buy Offer
**Request:**
```
POST /transactions/item/5
Content-Type: application/x-www-form-urlencoded

type=buy
offer_amount=450
total_price=450
notes=Can you accept $450?
```

**Response:**
```
Redirect to /transactions/12 with success message
```

### Make Trade Offer
**Request:**
```
POST /transactions/item/5
Content-Type: application/x-www-form-urlencoded

type=trade
offer_item_id=8
total_price=500
notes=Interested in this trade!
```

**Response:**
```
Redirect to /transactions/13 with success message
```

---

## Common Query Parameters

### Marketplace Search
- `?search=sword` - Search by name/description
- `?category=weapon` - Filter by category
- `?min_price=100` - Minimum price
- `?max_price=500` - Maximum price
- `?seller=5` - Filter by seller ID
- `?page=2` - Pagination

### Pagination
- `?page=1` - First page (default)
- `?page=2` - Second page
- Items per page: 12 for marketplace, 15 for admin lists, 20 for transactions

---

## Error Messages

### Validation Errors
- "name is required"
- "price must be numeric"
- "image must be an image"

### Authorization Errors
- "Cannot trade your own item"
- "Item is no longer available"
- "Only seller can accept this trade"
- "Unauthorized access"

### State Errors
- "Cannot cancel completed or rejected transactions"
- "This trade cannot be accepted"
- "Only accepted trades can be completed"

---

## Cache Keys (if implemented)
```
user:{user_id}:items
user:{user_id}:transactions
item:{item_id}:details
marketplace:available:items
```

---

## File Upload Paths
```
storage/app/public/items/          → Item images
storage/app/public/avatars/        → User avatars
public/storage/items/              → Public access for item images
public/storage/avatars/            → Public access for avatars
```

---

## Session Keys (if needed)
```
auth.id         → Currently logged-in user ID
flash.success   → Success message
flash.error     → Error message
```
