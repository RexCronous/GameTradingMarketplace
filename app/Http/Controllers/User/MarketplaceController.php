<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Item;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MarketplaceController extends Controller
{
    public function index(Request $request)
    {
        $query = Item::where('status', 'available')
            ->where('user_id', '!=', Auth::id())
            ->with('user');

        // Search
        if ($request->filled('search')) {
            $query->where('name', 'ILIKE', '%' . $request->search . '%')
                ->orWhere('description', 'ILIKE', '%' . $request->search . '%');
        }

        // Filter by price
        if ($request->filled('min_price')) {
            $query->where('price', '>=', $request->min_price);
        }

        if ($request->filled('max_price')) {
            $query->where('price', '<=', $request->max_price);
        }

        // Filter by category
        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }

        // Filter by seller
        if ($request->filled('seller')) {
            $query->where('user_id', $request->seller);
        }

        $items = $query->paginate(12);
        $categories = Item::distinct('category')->pluck('category');

        return view('marketplace.index', compact('items', 'categories'));
    }

    public function show(Item $item)
    {
        if ($item->user_id === Auth::id()) {
            abort(403, 'You cannot view your own items in marketplace');
        }

        /** @var \App\Models\User $user */
        $user = Auth::user();
        if ($user)
            return view('marketplace.show', [
                'item' => $item,
                'myItems' =>$user->items()->where('status', 'available')->get(),
            ]);
        return view('marketplace.show', [
                'item' => $item,
                'myItems' => Item::whereRaw('1 = 0')->get(), // empty collection
            ]);
    }
}