<?php

namespace App\Http\Controllers;

use App\Models\Item;
use Illuminate\Support\Facades\Auth;

class MarketplaceController extends Controller
{
    public function index()
    {
        $query = Item::where('status', 'available')->where('user_id', '!=', Auth::id());

        if (request('search')) {
            $query->where('name', 'like', '%' . request('search') . '%')
                  ->orWhere('description', 'like', '%' . request('search') . '%');
        }

        if (request('sort') === 'price_asc') {
            $query->orderBy('price', 'asc');
        } elseif (request('sort') === 'price_desc') {
            $query->orderBy('price', 'desc');
        } else {
            $query->latest();
        }

        return view('marketplace.index', [
            'items' => $query->paginate(12),
        ]);
    }

    public function show(Item $item)
    {
        if ($item->user_id === Auth::id()) {
            abort(403, 'Cannot view your own items in marketplace');
        }

        return view('marketplace.show', [
            'item' => $item,
            'myItems' => Auth::user()->items()->where('status', 'available')->get(),
        ]);
    }
}
