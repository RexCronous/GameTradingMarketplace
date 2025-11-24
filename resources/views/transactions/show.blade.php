@extends('layouts.main')

@section('title', 'Transaction Details')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Transaction Details</h3>
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <h6>Item</h6>
                            <p>
                                <strong>{{ $transaction->item->name }}</strong><br>
                                <img src="{{ $transaction->item->image ? asset('storage/' . $transaction->item->image) : 'https://via.placeholder.com/200' }}" style="max-width: 200px; max-height: 200px;">
                            </p>
                        </div>
                        <div class="col-md-6">
                            <h6>Transaction Info</h6>
                            <p>
                                <strong>Type:</strong> {{ ucfirst($transaction->type) }}<br>
                                <strong>Status:</strong> 
                                <span class="badge badge-{{ 
                                    $transaction->status === 'pending' ? 'warning' : 
                                    ($transaction->status === 'completed' ? 'success' : 
                                    ($transaction->status === 'rejected' ? 'danger' : 'info'))
                                }}">
                                    {{ ucfirst($transaction->status) }}
                                </span><br>
                                <strong>Created:</strong> {{ $transaction->created_at->format('M d, Y H:i') }}<br>
                                <strong>Updated:</strong> {{ $transaction->updated_at->format('M d, Y H:i') }}
                            </p>
                        </div>
                    </div>

                    <hr>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <h6>Buyer</h6>
                            <p>
                                <strong>{{ $transaction->buyer->name }}</strong><br>
                                <small class="text-muted">{{ $transaction->buyer->email }}</small><br>
                                <small class="text-muted">@{{ $transaction->buyer->profile->username ?? 'N/A' }}</small>
                            </p>
                        </div>
                        <div class="col-md-6">
                            <h6>Seller</h6>
                            <p>
                                <strong>{{ $transaction->seller->name }}</strong><br>
                                <small class="text-muted">{{ $transaction->seller->email }}</small><br>
                                <small class="text-muted">@{{ $transaction->seller->profile->username ?? 'N/A' }}</small>
                            </p>
                        </div>
                    </div>

                    <hr>

                    <div class="row">
                        <div class="col-md-6">
                            <h6>Item Price</h6>
                            <p class="text-primary font-weight-bold">₱{{ number_format($transaction->item->price, 2) }}</p>
                        </div>

                        @if($transaction->type === 'trade')
                            <div class="col-md-6">
                                <h6>Trade Details</h6>
                                @if($transaction->offer_item_id)
                                    <p>
                                        <strong>Offered Item:</strong> {{ $transaction->offerItem->name }}<br>
                                        <strong>Value:</strong> ₱{{ number_format($transaction->offerItem->price, 2) }}
                                    </p>
                                @else
                                    <p>
                                        <strong>Offered Amount:</strong> ₱{{ number_format($transaction->offer_amount, 2) }}
                                    </p>
                                @endif
                            </div>
                        @else
                            <div class="col-md-6">
                                <h6>Total Price</h6>
                                <p class="text-success font-weight-bold">₱{{ number_format($transaction->total_price, 2) }}</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Actions</h3>
                </div>
                <div class="card-body">
                    @if($transaction->status === 'pending')
                        @if(Auth::id() === $transaction->seller_id)
                            <p class="text-sm text-muted mb-3">You can accept or reject this trade offer.</p>
                            <form action="{{ route('transactions.accept', $transaction) }}" method="POST" class="mb-2">
                                @csrf
                                <button type="submit" class="btn btn-success w-100">
                                    <i class="fas fa-check"></i> Accept Trade
                                </button>
                            </form>
                            <form action="{{ route('transactions.reject', $transaction) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-danger w-100" onclick="return confirm('Reject this trade?')">
                                    <i class="fas fa-times"></i> Reject Trade
                                </button>
                            </form>
                        @elseif(Auth::id() === $transaction->buyer_id)
                            <p class="text-sm text-muted">Waiting for seller to respond...</p>
                        @endif
                    @elseif($transaction->status === 'accepted' && Auth::id() === $transaction->buyer_id)
                        <p class="text-sm text-success mb-3">Trade accepted! Complete the transaction.</p>
                        <form action="{{ route('transactions.complete', $transaction) }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-primary w-100">
                                <i class="fas fa-check-circle"></i> Complete Trade
                            </button>
                        </form>
                    @elseif($transaction->status === 'completed')
                        <div class="alert alert-success">
                            <i class="fas fa-check-circle"></i> Trade completed successfully!
                        </div>
                    @elseif($transaction->status === 'rejected')
                        <div class="alert alert-danger">
                            <i class="fas fa-times-circle"></i> Trade was rejected.
                        </div>
                    @endif

                    <hr>
                    <a href="{{ route('transactions.index') }}" class="btn btn-secondary w-100">Back to Transactions</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
