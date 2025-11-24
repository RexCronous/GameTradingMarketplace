@extends('layouts.app')

@section('title', 'Transaction Details')
@section('page-title', 'Transaction Details')

@section('content')
<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Transaction #{{ $transaction->id }}</h3>
            </div>
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-md-6">
                        <h6>Transaction Information</h6>
                        <table class="table table-sm">
                            <tr>
                                <td><strong>ID:</strong></td>
                                <td>#{{ $transaction->id }}</td>
                            </tr>
                            <tr>
                                <td><strong>Type:</strong></td>
                                <td>
                                    <span class="badge badge-{{ $transaction->isBuyType() ? 'info' : 'success' }}">
                                        {{ ucfirst($transaction->type) }}
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <td><strong>Status:</strong></td>
                                <td>
                                    <span class="badge badge-{{ match($transaction->status) {
                                        'pending' => 'warning',
                                        'accepted' => 'info',
                                        'completed' => 'success',
                                        'rejected' => 'danger',
                                        default => 'secondary'
                                    } }}">
                                        {{ ucfirst($transaction->status) }}
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <td><strong>Created:</strong></td>
                                <td>{{ $transaction->created_at->format('M d, Y H:i') }}</td>
                            </tr>
                            @if($transaction->accepted_at)
                                <tr>
                                    <td><strong>Accepted:</strong></td>
                                    <td>{{ $transaction->accepted_at->format('M d, Y H:i') }}</td>
                                </tr>
                            @endif
                            @if($transaction->completed_at)
                                <tr>
                                    <td><strong>Completed:</strong></td>
                                    <td>{{ $transaction->completed_at->format('M d, Y H:i') }}</td>
                                </tr>
                            @endif
                        </table>
                    </div>

                    <div class="col-md-6">
                        <h6>Parties</h6>
                        <table class="table table-sm">
                            <tr>
                                <td><strong>Buyer:</strong></td>
                                <td>{{ $transaction->buyer->name }}</td>
                            </tr>
                            <tr>
                                <td><strong>Seller:</strong></td>
                                <td>{{ $transaction->seller->name }}</td>
                            </tr>
                        </table>
                    </div>
                </div>

                <hr>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <h6>Item Being Sold</h6>
                        <div class="card">
                            @if($transaction->item->image)
                                <img src="{{ $transaction->item->getImageUrl() }}" class="card-img-top" alt="">
                            @endif
                            <div class="card-body">
                                <h5>{{ $transaction->item->name }}</h5>
                                <p class="text-muted">{{ Str::limit($transaction->item->description, 80) }}</p>
                                <h4 class="text-primary">${{ number_format($transaction->item->price, 2) }}</h4>
                            </div>
                        </div>
                    </div>

                    @if($transaction->isTradeType() && $transaction->offerItem)
                        <div class="col-md-6">
                            <h6>Item Being Traded</h6>
                            <div class="card">
                                @if($transaction->offerItem->image)
                                    <img src="{{ $transaction->offerItem->getImageUrl() }}" class="card-img-top" alt="">
                                @endif
                                <div class="card-body">
                                    <h5>{{ $transaction->offerItem->name }}</h5>
                                    <p class="text-muted">{{ Str::limit($transaction->offerItem->description, 80) }}</p>
                                    <h4 class="text-primary">${{ number_format($transaction->offerItem->price, 2) }}</h4>
                                </div>
                            </div>
                        </div>
                    @elseif($transaction->isBuyType())
                        <div class="col-md-6">
                            <h6>Offer Amount</h6>
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="text-success">${{ number_format($transaction->offer_amount, 2) }}</h4>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>

                @if($transaction->notes)
                    <div class="alert alert-info">
                        <strong>Message from {{ $transaction->isBuyType() || $transaction->buyer_id === auth()->id() ? 'Buyer' : 'Seller' }}:</strong>
                        <p class="mb-0">{{ $transaction->notes }}</p>
                    </div>
                @endif

                <!-- Actions for Seller -->
                @if($is_seller && $transaction->isPending())
                    <div class="mt-3">
                        <form action="{{ route('user.transactions.accept', $transaction) }}" method="POST" style="display:inline;">
                            @csrf
                            <button type="submit" class="btn btn-success">
                                <i class="fas fa-check"></i> Accept Offer
                            </button>
                        </form>
                        <form action="{{ route('user.transactions.reject', $transaction) }}" method="POST" style="display:inline;">
                            @csrf
                            <button type="submit" class="btn btn-danger">
                                <i class="fas fa-times"></i> Reject Offer
                            </button>
                        </form>
                    </div>
                @endif

                <!-- Actions for Buyer -->
                @if(!$is_seller && $transaction->isAccepted())
                    <div class="mt-3">
                        <form action="{{ route('user.transactions.complete', $transaction) }}" method="POST" style="display:inline;">
                            @csrf
                            <button type="submit" class="btn btn-success">
                                <i class="fas fa-check-circle"></i> Confirm Completion
                            </button>
                        </form>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
