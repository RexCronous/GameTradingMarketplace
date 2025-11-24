# Trading System Workflow Documentation

## Trade Types & Flow

### 1. BUY Transaction Flow

```
User 1 (Buyer)          Item Owner (Seller)
     │                          │
     ├─→ Browse Marketplace ←───┤
     │                          │
     ├─→ Select Item            │
     │   └─→ Enter Offer Amount │
     │                          │
     ├─→ Send Offer ────────────→ Receives notification
     │   Transaction Status: PENDING
     │                          │
     │                       [Decision]
     │                          │
     │   ←────── Accept ────────┤ Changes Status: ACCEPTED
     │   ←────── Reject ────────┤ Changes Status: REJECTED
     │
   [If Accepted]
     │
     ├─→ Confirm Completion ────→
     │   Item Status: SOLD
     │   Transaction Status: COMPLETED
```

**Database Record:**
```
- type: 'buy'
- offer_item_id: NULL
- offer_amount: (buyer's offer)
- total_price: item.price
- status: pending → accepted → completed
```

---

### 2. TRADE Transaction Flow

```
User 1 (Offers Item A)     Item Owner (Owns Item B)
     │                              │
     ├─→ Browse Marketplace ←───────┤
     │                              │
     ├─→ Select Item B              │
     │   └─→ Choose Item A          │
     │       (from own inventory)   │
     │                              │
     ├─→ Send Trade Offer ─────────→ Receives notification
     │   Transaction Status: PENDING
     │                              │
     │                           [Decision]
     │                              │
     │   ←────── Accept ───────────┤ Both items status: TRADED
     │   ←────── Reject ───────────┤ Status: REJECTED
     │
   [If Accepted]
     │
     ├─→ Confirm Completion ──────→
     │   Item A Status: TRADED
     │   Item B Status: TRADED
     │   Transaction Status: COMPLETED
     │   Ownership transfers complete
```

**Database Record:**
```
- type: 'trade'
- offer_item_id: (user's item to trade)
- offer_amount: NULL
- total_price: max(item_a.price, item_b.price)
- status: pending → accepted → completed
```

---

## Status Transitions

### Transaction Status Flow

```
┌─────────────┐
│   PENDING   │  ← Initial state when offer created
└─────┬───────┘
      │
      ├──→ [Seller Accepts] ──→ ┌──────────┐
      │                         │ ACCEPTED │
      │                         └─────┬────┘
      │                               │
      │                         [Buyer Confirms]
      │                               │
      │                         ┌───────────────┐
      │                         │  COMPLETED    │ ← Final state
      │                         └───────────────┘
      │
      ├──→ [Seller Rejects] ──→ ┌──────────┐
      │                         │ REJECTED │ ← Final state
      │                         └──────────┘
      │
      └──→ [Admin Cancels] ───→ ┌────────────┐
                                │ CANCELLED  │ ← Final state
                                └────────────┘
```

### Item Status Lifecycle

```
Available  →  Pending Trade  →  Traded/Sold
   ↑                               ↓
   └─ Can always revert to Available (if item not traded yet)
```

---

## Authorization Rules

### User Permissions

**Can DO:**
- ✅ Create items
- ✅ Edit/Delete own items
- ✅ Browse other users' items
- ✅ Make buy offers
- ✅ Make trade offers
- ✅ Accept trade offers (if seller)
- ✅ Reject trade offers (if seller)
- ✅ Complete trades (as buyer)
- ✅ View own transaction history
- ✅ Update own profile

**Cannot DO:**
- ❌ Buy/Trade own items
- ❌ View other users' full profiles
- ❌ Accept/Reject offers they didn't receive
- ❌ Delete other users' items
- ❌ Edit other users' profiles
- ❌ View admin dashboard

### Admin Permissions

**Can DO:**
- ✅ Access all user data
- ✅ View all transactions
- ✅ Cancel pending transactions
- ✅ Delete any item
- ✅ Delete any user account
- ✅ View system statistics
- ✅ Monitor marketplace health

---

## Validation Rules

### Item Creation/Update
```
- name: required, max 255
- description: nullable, max 1000
- price: required, numeric, min 0, max 999999.99
- category: nullable, max 100
- quantity: required, integer, min 1
- image: nullable, image, max 5MB
- status: must be available/sold/traded
```

### Transaction Creation
```
- type: required, must be 'buy' or 'trade'
- offer_amount: required if type=buy, numeric, min 0
- offer_item_id: required if type=trade, exists in items table
- total_price: required, numeric, min 0
- notes: nullable, max 500
```

---

## Error Prevention

### System Prevents:
1. ❌ User buying their own item
2. ❌ User trading with unavailable items
3. ❌ Accepting rejected offers
4. ❌ Creating offer for sold item
5. ❌ Double-spending (item can't be traded twice)
6. ❌ Invalid transitions (accepting already rejected trade)

---

## Transaction Completion Logic

When transaction is marked COMPLETED:

### For BUY Type:
```sql
UPDATE items SET status = 'sold' WHERE id = transaction.item_id
```

### For TRADE Type:
```sql
UPDATE items SET status = 'traded' WHERE id IN (
    transaction.item_id, 
    transaction.offer_item_id
)
```

---

## Timestamps

All transactions track:
- `created_at`: When offer was initiated
- `accepted_at`: When seller accepted (nullable)
- `rejected_at`: When seller rejected (nullable)
- `completed_at`: When trade was completed (nullable)

---

## Example Scenarios

### Scenario 1: Simple Item Purchase

```
1. John creates item "Sword" ($500)
   → Item status: available

2. Jane browses marketplace, finds "Sword"
   → Jane offers $500

3. John receives notification
   → John accepts

4. Jane confirms completion
   → Transaction status: completed
   → Sword status: sold
   → Ownership transfers to Jane
```

### Scenario 2: Item Trade

```
1. John creates "Sword" ($500), price = available
2. Jane creates "Shield" ($400), price = available

3. Jane offers "Shield" for "Sword"
   → Transaction created
   → type: trade
   → offer_item_id: Shield.id

4. John accepts

5. Jane confirms completion
   → Both items status: traded
   → Ownership transfers complete
```

### Scenario 3: Rejected Trade

```
1. Jane offers Shield for Sword

2. John rejects
   → Transaction status: rejected
   → Both items remain available
   → Jane can make another offer
```

---

## Database Relationships

```
User --1:N--> Item
User --1:N--> Transaction (as buyer_id)
User --1:N--> Transaction (as seller_id)
User --1:1--> Profile

Item --1:N--> Transaction
Item --self--> Item (offer_item_id foreign key)

Transaction relationships:
- belongsTo(Item)
- belongsTo(User, 'buyer_id')
- belongsTo(User, 'seller_id')
- belongsTo(Item, 'offer_item_id') [nullable]
```

---

## Notes & Best Practices

1. **Always validate** item ownership before allowing edits
2. **Check item status** before creating transactions
3. **Prevent concurrent updates** - use database locks if needed
4. **Log all transactions** for audit purposes
5. **Consider escrow system** for real payments (future enhancement)
6. **Notify users** of transaction status changes
7. **Rate limiting** on offer creation to prevent spam
