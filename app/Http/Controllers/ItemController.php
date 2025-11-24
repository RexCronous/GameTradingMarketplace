<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Http\Requests\ItemRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;

class ItemController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except(['index', 'show']);
    }

    public function index(Request $request)
    {
        $query = Item::where('status', '==', 'available', true);

        if (Auth::check()) {
            $query->where('user_id', '!=', Auth::id());
        }

        if ($request->has('min_price')) {
            $query->where('price', '>=', $request->min_price);
        }

        if ($request->has('max_price')) {
            $query->where('price', '<=', $request->max_price);
        }

        if ($request->has('search')) {
            $search = $request->search;
            $query->where('name', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
        }

        $items = $query->with('user.profile')
            ->paginate(12)
            ->appends($request->query());

        if ($request->wantsJson()) {
            return response()->json($items);
        }

        return view('marketplace.index', compact('items'));
    }

    public function create()
    {
        return view('items.create');
    }

    public function store(ItemRequest $request)
    {
        $data = $request->validated();

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('items', 'public');
            $data['image'] = $path;
        }

        $data['user_id'] = Auth::id();
        $data['status'] = 'available';

        Item::create($data);

        return redirect()->route('dashboard')->with('success', 'Item created successfully!');
    }

    public function show(Item $item)
    {
        return view('items.show', compact('item'));
    }

    public function edit(Item $item)
    {
        $this->authorize('update', $item);
        return view('items.edit', compact('item'));
    }

    public function update(ItemRequest $request, Item $item)
    {
        $this->authorize('update', $item);

        $data = $request->validated();

        if ($request->hasFile('image')) {
            if ($item->image) {
                Storage::disk('public')->delete($item->image);
            }
            $path = $request->file('image')->store('items', 'public');
            $data['image'] = $path;
        }

        $item->update();

        return redirect()->route('items.show', $item)->with('success', 'Item updated successfully!');
    }

    public function destroy(Item $item)
    {
        $this->authorize('delete', $item);

        if ($item->image) {
            Storage::disk('public')->delete($item->image);
        }

        $item->delete($item->id);

        return redirect()->route('dashboard')->with('success', 'Item deleted successfully!');
    }
}
