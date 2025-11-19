<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Offer;
use App\Models\Item;
use App\Models\Transaction;
use App\Models\TransactionItem;
use App\Http\Requests\OfferRequest;
use Illuminate\Support\Facades\Auth;


class OfferController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $offers = Offer::where('offerer_id', Auth::id())->orWhereHas('item', function ($q) {
            $q->where('user_id', Auth::id());
        })->get();
        return response()->json($offers);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return response()->json(['message' => 'render offer form']);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(OfferRequest $request)
    {
        $data = $request->validated();
        $item = Item::findOrFail($data['item_id']);
        if ($item->user_id === Auth::id()) {
            return response()->json(['message' => 'cannot offer on your own item'], 403);
        }
        $offer = Offer::create([
            'item_id' => $item->id,
            'offerer_id' => Auth::id(),
            'cash_amount' => $data['cash_amount'] ?? null,
            'offered_item_ids' => $data['offered_item_ids'] ?? null,
            'status' => 'pending',
        ]);
        return response()->json($offer, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $offer = Offer::findOrFail($id);
        return response()->json($offer);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $offer = Offer::findOrFail($id);
        return response()->json($offer);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $offer = Offer::findOrFail($id);
        if ($offer->offerer_id !== Auth::id()) {
            return response()->json(['message' => 'forbidden'], 403);
        }
        $offer->update($request->only(['cash_amount', 'offered_item_ids']));
        return response()->json($offer);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $offer = Offer::findOrFail($id);
        if ($offer->offerer_id !== Auth::id() && $offer->item->user_id !== Auth::id()) {
            return response()->json(['message' => 'forbidden'], 403);
        }
        $offer->delete();
        return response()->json(['message' => 'deleted']);
    }

    // Owner accepts an offer
    public function accept(string $id)
    {
        $offer = Offer::findOrFail($id);
        $item = $offer->item;
        if ($item->user_id !== Auth::id()) {
            return response()->json(['message' => 'forbidden'], 403);
        }

        $offer->status = 'accepted';
        $offer->save();

        // create transaction
        $transaction = Transaction::create([
            'buyer_id' => $offer->offerer_id,
            'seller_id' => $item->user_id,
            'total_price' => $offer->cash_amount ?? $item->price,
            'type' => $offer->offered_item_ids ? 'trade' : 'buy',
            'status' => 'completed',
        ]);

        // add item to transaction and mark status
        TransactionItem::create([
            'transaction_id' => $transaction->id,
            'item_id' => $item->id,
            'direction' => 'to_buyer',
        ]);
        $item->status = $offer->offered_item_ids ? 'traded' : 'sold';
        $item->save();

        // if offered items are present, mark them traded and attach
        if (!empty($offer->offered_item_ids) && is_array($offer->offered_item_ids)) {
            foreach ($offer->offered_item_ids as $offeredId) {
                $offItem = Item::find($offeredId);
                if ($offItem) {
                    TransactionItem::create([
                        'transaction_id' => $transaction->id,
                        'item_id' => $offItem->id,
                        'direction' => 'to_seller',
                    ]);
                    $offItem->status = 'traded';
                    $offItem->save();
                }
            }
        }

        return response()->json($transaction, 201);
    }

    // Owner rejects an offer
    public function reject(string $id)
    {
        $offer = Offer::findOrFail($id);
        $item = $offer->item;
        if ($item->user_id !== Auth::id()) {
            return response()->json(['message' => 'forbidden'], 403);
        }
        $offer->status = 'rejected';
        $offer->save();
        return response()->json(['message' => 'rejected']);
    }
}
