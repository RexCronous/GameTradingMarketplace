<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Item;
use App\Http\Requests\StoreItemRequest;
use App\Http\Requests\UpdateItemRequest;
use Illuminate\Support\Facades\Auth;

class ItemController extends Controller
{
    public function index()
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        $items = $user->items()->paginate(12);
        return view('user.items.index', compact('items'));
    }

    public function create()
    {
        return view('user.items.create');
    }

    public function store(StoreItemRequest $request)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user(); 
        $data = $request->validated();

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('items', 'public');
        }

        $user->items()->create($data);
        return redirect()->route('user.items.index')->with('success', 'Item created successfully');
    }

    public function edit(Item $item)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user(); 
        if ($user->id !== $item->user_id && !$user->isAdmin()) {
            abort(403);
        }
        return view('user.items.edit', compact('item'));
    }

    public function update(UpdateItemRequest $request, Item $item)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user(); 
        if ($user->id !== $item->user_id && !$user->isAdmin()) {
            abort(403);
        }
        $data = $request->validated();

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('items', 'public');
        }

        $item->update($data);
        return redirect()->route('user.items.index')->with('success', 'Item updated successfully');
    }

    public function destroy(Item $item)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user(); 
        if ($user->id !== $item->user_id && !$user->isAdmin()) {
            abort(403);
        }
        $item->delete();
        return redirect()->route('user.items.index')->with('success', 'Item deleted successfully');
    }
}
