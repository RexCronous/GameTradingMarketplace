@extends('layouts.app')

@section('page-title', 'Pending Offers')

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-inbox"></i> Pending Offers for Your Items
                </h3>
            </div>
            <div class="card-body">
                @forelse($offers as $offer)
                    <div class="card mb-3 border">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-2">
                                    <img src="{{ $offer->item->getImageUrl() }}" alt="{{ $offer->item->name }}" class="img-fluid rounded" style="height: 100px; object-fit: cover;">
                                </div>
                                <div class="col-md-5">
                                    <h5>{{ $offer->item->name }}</h5>
                                    <p class="text-muted">{{ $offer->item->description }}</p>
                                    <p><strong>Your Item Price:</strong> ${{ number_format($offer->item->price, 2) }}</p>
                                </div>
                                <div class="col-md-3">
                                    <h6 class="text-info">Offer from <strong>{{ $offer->buyer->name }}</strong></h6>
                                    @if($offer->type === 'trade' && $offer->offerItem)
                                        <p>
                                            <strong>Offers:</strong> {{ $offer->offerItem->name }}<br>
                                            <small>Value: ${{ number_format($offer->offerItem->price, 2) }}</small>
                                        </p>
                                    @elseif($offer->type === 'buy')
                                        <p><strong>Offers:</strong> ${{ number_format($offer->offer_amount ?? 0, 2) }}</p>
                                    @endif
                                    @if($offer->message)
                                        <p><em>"{{ $offer->message }}"</em></p>
                                    @endif
                                </div>
                                <div class="col-md-2 text-right">
                                    <form method="POST" action="{{ route('transactions.accept', $offer) }}" style="display:inline;">
                                        @csrf
                                        <button type="submit" class="btn btn-sm btn-success mb-2">
                                            <i class="fas fa-check"></i> Accept
                                        </button>
                                    </form>
                                    <form method="POST" action="{{ route('transactions.reject', $offer) }}" style="display:inline;">
                                        @csrf
                                        <button type="submit" class="btn btn-sm btn-danger">
                                            <i class="fas fa-times"></i> Reject
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="alert alert-info text-center">
                        <p>No pending offers at the moment.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</div>

<div class="row mt-3">
    <div class="col-md-12">
        {{ $offers->links() }}
    </div>
</div>
@endsection
