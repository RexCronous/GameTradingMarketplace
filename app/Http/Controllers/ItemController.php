<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;
use App\Http\Requests\ItemRequest;
use Illuminate\Support\Facades\Auth;

class ItemController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // show available items for browsing (exclude own items)
        $query = Item::query()->where('status', 'available');
        if (Auth::check()) {
            $query->where('user_id', '!=', Auth::id());
        }
        $items = $query->get();
        if ($request->wantsJson()) {
            return response()->json($items);
        }
        return view('items.index', ['items' => $items]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('items.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ItemRequest $request)
    {
        $data = $request->validated();
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('items', 'public');
            $data['image_path'] = $path;
        }
        $data['user_id'] = Auth::id();
        $data['status'] = $data['status'] ?? 'available';
        $item = Item::create($data);
        return redirect()->route('items.index')->with('success', 'Item created.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, string $id)
    {
        $item = Item::findOrFail($id);
        if ($request->wantsJson()) {
            return response()->json($item);
        }
        return view('items.show', ['item' => $item]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $item = Item::findOrFail($id);
        return view('items.edit', ['item' => $item]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ItemRequest $request, string $id)
    {
        $item = Item::findOrFail($id);
        if ($item->user_id !== Auth::id()) {
            abort(403);
        }
        $data = $request->validated();
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('items', 'public');
            $data['image_path'] = $path;
        }
        $item->update($data);
        return redirect()->route('items.show', $item->id)->with('success', 'Item updated.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $item = Item::findOrFail($id);
        if ($item->user_id !== Auth::id()) {
            abort(403);
        }
        $item->delete();
        return redirect()->route('items.index')->with('success', 'Item deleted.');
    }
}
