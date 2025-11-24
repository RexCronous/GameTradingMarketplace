@extends('layouts.app')

@section('title', 'Transaction Details')
@section('page-title', 'Transaction #' . $transaction->id)

@section('content')
<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Transaction Information</h3>
            </div>
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-md-6">
                        <table class="table table-sm">
                            <tr>
                                <td><strong>Transaction ID:</strong></td>
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
                                <td><strong>Amount:</strong></td>
                                <td>${{ number_format($transaction->total_price, 2) }}</td>
                            </tr>
                        </table>
                    </div>

                    <div class="col-md-6">
                        <table class="table table-sm">
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
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Parties Involved</h3>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <strong>Buyer:</strong>
                        <a href="{{ route('admin.users.show', $transaction->buyer) }}">{{ $transaction->buyer->name }}</a>
                        <br>
                        <small class="text-muted">{{ $transaction->buyer->email }}</small>
                    </div>

                    <div class="col-md-6">
                        <strong>Seller:</strong>
                        <a href="{{ route('admin.users.show', $transaction->seller) }}">{{ $transaction->seller->name }}</a>
                        <br>
                        <small class="text-muted">{{ $transaction->seller->email }}</small>
                    </div>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Item Details</h3>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <strong>Item Being Sold:</strong>
                        <div class="mt-2">
                            <a href="{{ route('admin.items.show', $transaction->item) }}">{{ $transaction->item->name }}</a>
                            <br>
                            <small class="text-muted">Price: ${{ number_format($transaction->item->price, 2) }}</small>
                        </div>
                    </div>

                    @if($transaction->isTradeType() && $transaction->offerItem)
                        <div class="col-md-6">
                            <strong>Item Being Traded:</strong>
                            <div class="mt-2">
                                <a href="{{ route('admin.items.show', $transaction->offerItem) }}">{{ $transaction->offerItem->name }}</a>
                                <br>
                                <small class="text-muted">Price: ${{ number_format($transaction->offerItem->price, 2) }}</small>
                            </div>
                        </div>
                    @elseif($transaction->isBuyType())
                        <div class="col-md-6">
                            <strong>Offer Amount:</strong>
                            <div class="mt-2">
                                <h4 class="text-success">${{ number_format($transaction->offer_amount, 2) }}</h4>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        @if($transaction->notes)
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Message</h3>
                </div>
                <div class="card-body">
                    <p>{{ $transaction->notes }}</p>
                </div>
            </div>
        @endif
    </div>

    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Actions</h3>
            </div>
            <div class="card-body">
                @if($transaction->isPending())
                    <div class="alert alert-info">
                        <small>This transaction is pending acceptance by the seller.</small>
                    </div>
                    <form action="{{ route('admin.transactions.cancel', $transaction) }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-warning btn-block" onclick="return confirm('Cancel this transaction?')">
                            <i class="fas fa-times"></i> Cancel Transaction
                        </button>
                    </form>
                @elseif($transaction->isAccepted())
                    <div class="alert alert-info">
                        <small>This transaction has been accepted and is awaiting completion.</small>
                    </div>
                @elseif($transaction->isCompleted())
                    <div class="alert alert-success">
                        <small>This transaction has been completed successfully.</small>
                    </div>
                @elseif($transaction->isRejected())
                    <div class="alert alert-danger">
                        <small>This transaction has been rejected.</small>
                    </div>
                @endif

                <a href="{{ route('admin.transactions.index') }}" class="btn btn-secondary btn-block">
                    <i class="fas fa-arrow-left"></i> Back to Transactions
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
