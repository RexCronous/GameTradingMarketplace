@extends('layouts.main')

@section('title', 'My Transactions')

@section('content')
<div class="container-fluid">
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Transaction History</h3>
        </div>
        <div class="card-body">
            @if($transactions->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Item</th>
                                <th>Type</th>
                                <th>With</th>
                                <th>Amount</th>
                                <th>Status</th>
                                <th>Date</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($transactions as $tx)
                            <tr>
                                <td><strong>{{ $tx->item->name }}</strong></td>
                                <td>
                                    <span class="badge badge-{{ $tx->type === 'buy' ? 'info' : 'primary' }}">
                                        {{ ucfirst($tx->type) }}
                                    </span>
                                </td>
                                <td>
                                    @if(Auth::id() === $tx->buyer_id)
                                        {{ $tx->seller->name }} (Seller)
                                    @else
                                        {{ $tx->buyer->name }} (Buyer)
                                    @endif
                                </td>
                                <td>₱{{ number_format($tx->total_price ?? $tx->offer_amount ?? 0, 2) }}</td>
                                <td>
                                    <span class="badge badge-{{ 
                                        $tx->status === 'pending' ? 'warning' : 
                                        ($tx->status === 'completed' ? 'success' : 
                                        ($tx->status === 'rejected' ? 'danger' : 'info'))
                                    }}">
                                        {{ ucfirst($tx->status) }}
                                    </span>
                                </td>
                                <td>{{ $tx->created_at->format('M d, Y') }}</td>
                                <td>
                                    <a href="{{ route('transactions.show', $tx) }}" class="btn btn-sm btn-info">View</a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                {{ $transactions->links() }}
            @else
                <p class="text-muted">You have no transactions yet.</p>
            @endif
        </div>
    </div>
</div>
@endsection
