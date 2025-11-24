@extends('layouts.app')

@section('page-title', 'Transaction History')

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between">
                <h3 class="card-title">My Transactions</h3>
                <a href="{{ route('transactions.offers') }}" class="btn btn-sm btn-info">
                    <i class="fas fa-inbox"></i> Pending Offers
                </a>
            </div>
            <div class="card-body">
                @forelse($transactions as $tx)
                    <div class="row mb-3 pb-3 border-bottom">
                        <div class="col-md-2">
                            <img src="{{ $tx->item->getImageUrl() }}" alt="{{ $tx->item->name }}" class="img-fluid rounded" style="height: 100px; object-fit: cover;">
                        </div>
                        <div class="col-md-5">
                            <h5>{{ $tx->item->name }}</h5>
                            @if($tx->type === 'trade' && $tx->offerItem)
                                <p><small><strong>Offered:</strong> {{ $tx->offerItem->name }}</small></p>
                            @elseif($tx->type === 'buy')
                                <p><small><strong>Offer:</strong> ${{ number_format($tx->offer_amount ?? 0, 2) }}</small></p>
                            @endif
                            <p class="text-muted text-sm">
                                @if($tx->buyer_id === Auth::id())
                                    <i class="fas fa-arrow-up text-success"></i> From {{ $tx->seller->name }}
                                @else
                                    <i class="fas fa-arrow-down text-info"></i> To {{ $tx->buyer->name }}
                                @endif
                            </p>
                        </div>
                        <div class="col-md-3">
                            <p>
                                <strong>Status:</strong>
                                <span class="badge badge-{{ $tx->status === 'completed' ? 'success' : ($tx->status === 'rejected' ? 'danger' : 'warning') }}">
                                    {{ ucfirst($tx->status) }}
                                </span>
                            </p>
                            <p><small class="text-muted">{{ $tx->created_at->format('M d, Y') }}</small></p>
                        </div>
                        <div class="col-md-2 text-right">
                            <a href="{{ route('transactions.show', $tx) }}" class="btn btn-sm btn-info">Details</a>
                        </div>
                    </div>
                @empty
                    <p class="text-muted text-center py-5">No transactions yet.</p>
                @endforelse
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
