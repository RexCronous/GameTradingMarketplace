@extends('layouts.app')

@section('page-title', 'All Transactions')

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">All Transactions</h3>
            </div>
            <div class="card-body">
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th>Item</th>
                            <th>Buyer</th>
                            <th>Seller</th>
                            <th>Type</th>
                            <th>Amount</th>
                            <th>Status</th>
                            <th>Created</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($transactions as $tx)
                            <tr>
                                <td>{{ $tx->item->name }}</td>
                                <td>{{ $tx->buyer->name }}</td>
                                <td>{{ $tx->seller->name }}</td>
                                <td><span class="badge badge-info">{{ ucfirst($tx->type) }}</span></td>
                                <td>
                                    @if($tx->type === 'buy')
                                        ${{ number_format($tx->offer_amount ?? 0, 2) }}
                                    @else
                                        Trade
                                    @endif
                                </td>
                                <td><span class="badge badge-{{ $tx->status === 'completed' ? 'success' : ($tx->status === 'rejected' ? 'danger' : 'warning') }}">{{ ucfirst($tx->status) }}</span></td>
                                <td>{{ $tx->created_at->format('M d, Y') }}</td>
                            </tr>
                        @empty
                            <tr><td colspan="7" class="text-center text-muted">No transactions found</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<div class="row mt-3">
    <div class="col-md-12">
        {{ $transactions->links() }}
    </div>
</div>
@endsection
