<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaction;
use Illuminate\Support\Facades\Auth;

class TransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tx = Transaction::where('buyer_id', Auth::id())->orWhere('seller_id', Auth::id())->get();
        return response()->json($tx);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return response()->json(['message' => 'render transaction form']);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        return response()->json(['message' => 'transactions are created via offer acceptance']);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $tx = Transaction::with('items.item')->findOrFail($id);
        if ($tx->buyer_id !== Auth::id() && $tx->seller_id !== Auth::id()) {
            return response()->json(['message' => 'forbidden'], 403);
        }
        return response()->json($tx);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $tx = Transaction::findOrFail($id);
        return response()->json($tx);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $tx = Transaction::findOrFail($id);
        return response()->json($tx);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $tx = Transaction::findOrFail($id);
        // do not allow arbitrary deletion via API
        return response()->json(['message' => 'not allowed'], 405);
    }
}
