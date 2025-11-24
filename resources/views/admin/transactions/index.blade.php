@extends('layouts.app')

@section('title', 'Manage Transactions')
@section('page-title', 'Manage Transactions')

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">All Transactions</h3>
    </div>
    <div class="card-body table-responsive">
        <table class="table table-striped table-hover">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Item</th>
                    <th>Buyer</th>
                    <th>Seller</th>
                    <th>Type</th>
                    <th>Amount</th>
                    <th>Status</th>
                    <th>Date</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($transactions as $transaction)
                    <tr>
                        <td>#{{ $transaction->id }}</td>
                        <td>{{ $transaction->item->name }}</td>
                        <td>{{ $transaction->buyer->name }}</td>
                        <td>{{ $transaction->seller->name }}</td>
                        <td>
                            <span class="badge badge-{{ $transaction->isBuyType() ? 'info' : 'success' }}">
                                {{ ucfirst($transaction->type) }}
                            </span>
                        </td>
                        <td>${{ number_format($transaction->total_price, 2) }}</td>
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
                        <td>{{ $transaction->created_at->format('M d, Y') }}</td>
                        <td>
                            <a href="{{ route('admin.transactions.show', $transaction) }}" class="btn btn-sm btn-info">
                                <i class="fas fa-eye"></i>
                            </a>
                            @if($transaction->isPending())
                                <form action="{{ route('admin.transactions.cancel', $transaction) }}" method="POST" style="display:inline;">
                                    @csrf
                                    <button type="submit" class="btn btn-sm btn-warning" onclick="return confirm('Cancel this transaction?')">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </form>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="9" class="text-center text-muted">No transactions found</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@if($transactions->hasPages())
    <div class="d-flex justify-content-center mt-3">
        {{ $transactions->links() }}
    </div>
@endif
@endsection
