@extends('layouts.main')

@section('title', 'Item: ' . $item->name)

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <img src="{{ $item->image ? asset('storage/' . $item->image) : 'https://via.placeholder.com/500' }}" class="card-img-top" style="height: 400px; object-fit: cover;">
            </div>
        </div>

        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <h2>{{ $item->name }}</h2>
                    <hr>
                    <p class="text-muted">by <strong>{{ $item->user->profile->username ?? $item->user->name }}</strong></p>
                    
                    <p class="text-muted">{{ $item->description }}</p>

                    <div class="mt-4">
                        <p class="text-2xl font-weight-bold text-primary">₱{{ number_format($item->price, 2) }}</p>
                        <span class="badge badge-lg badge-{{ $item->status === 'available' ? 'success' : ($item->status === 'sold' ? 'danger' : 'warning') }}">
                            {{ ucfirst($item->status) }}
                        </span>
                    </div>

                    <hr>

                    @auth
                        @if(Auth::id() !== $item->user_id && $item->status === 'available')
                            <div class="btn-group w-100" role="group">
                                <form action="{{ route('items.buy', $item) }}" method="POST" class="flex-fill mr-1">
                                    @csrf
                                    <button type="submit" class="btn btn-success w-100">
                                        <i class="fas fa-shopping-cart"></i> Buy Now
                                    </button>
                                </form>

                                <button type="button" class="btn btn-info w-100" data-toggle="modal" data-target="#tradeModal">
                                    <i class="fas fa-exchange-alt"></i> Trade
                                </button>
                            </div>

                            <!-- Trade Modal -->
                            <div class="modal fade" id="tradeModal" tabindex="-1">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Trade Offer</h5>
                                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                        </div>
                                        <form action="{{ route('items.trade', $item) }}" method="POST">
                                            @csrf
                                            <div class="modal-body">
                                                <p>Trade with your own item or offer money.</p>
                                                
                                                <div class="form-group">
                                                    <label>Select an item from your inventory</label>
                                                    <select name="offer_item_id" class="form-control" id="offerItem">
                                                        <option value="">-- No item --</option>
                                                        @foreach(Auth::user()->items()->where('status', 'available')->get() as $myItem)
                                                            <option value="{{ $myItem->id }}">{{ $myItem->name }} (₱{{ $myItem->price }})</option>
                                                        @endforeach
                                                    </select>
                                                </div>

                                                <div class="form-group">
                                                    <label>OR offer an amount (PHP)</label>
                                                    <input type="number" name="offer_amount" class="form-control" step="0.01" min="0" id="offerAmount">
                                                </div>

                                                <small class="text-muted">Either select an item or enter an amount.</small>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                                <button type="submit" class="btn btn-primary">Send Trade Offer</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @elseif(Auth::id() === $item->user_id)
                            <p class="text-muted"><i class="fas fa-info-circle"></i> This is your item.</p>
                        @else
                            <p class="alert alert-warning">This item is no longer available.</p>
                        @endif
                    @else
                        <p class="alert alert-info">
                            <a href="{{ route('login') }}">Login</a> or <a href="{{ route('register') }}">register</a> to trade or buy items.
                        </p>
                    @endauth

                    <hr>

                    <div class="card bg-light">
                        <div class="card-body">
                            <h6>Seller Information</h6>
                            <p><strong>Name:</strong> {{ $item->user->name }}</p>
                            <p><strong>Username:</strong> {{ $item->user->profile->username ?? 'N/A' }}</p>
                            <p><strong>Bio:</strong> {{ $item->user->profile->bio ?? 'No bio' }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-4">
        <div class="col-md-12">
            <a href="{{ route('marketplace.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Back to Marketplace
            </a>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.getElementById('offerItem').addEventListener('change', function() {
    if (this.value) {
        document.getElementById('offerAmount').value = '';
        document.getElementById('offerAmount').disabled = true;
    } else {
        document.getElementById('offerAmount').disabled = false;
    }
});

document.getElementById('offerAmount').addEventListener('input', function() {
    if (this.value) {
        document.getElementById('offerItem').value = '';
        document.getElementById('offerItem').disabled = true;
    } else {
        document.getElementById('offerItem').disabled = false;
    }
});
</script>
@endpush
@endsection
