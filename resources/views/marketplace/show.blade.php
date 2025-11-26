@extends('layouts.app')

@section('page-title', $item->name)

@section('content')
<div class="row">
    <div class="col-md-6">
        <div class="card">
            <img src="{{ $item->getImageUrl() }}" class="card-img-top" alt="{{ $item->name }}" style="height: 300px; object-fit: cover;">
            <div class="card-body">
                <h2>{{ $item->name }}</h2>
                <p class="text-muted">{{ $item->description }}</p>
                <h3 class="text-success">${{ number_format($item->price, 2) }}</h3>
                <p><small class="text-muted">Listed by <strong>{{ $item->user->name }}</strong></small></p>
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Make an Offer</h3>
            </div>
            <form action="{{ route('user.transactions.store', $item->id) }}" method="POST">
                @csrf

                <div class="card-body">
                    <div class="form-group">
                        <label for="type">Trade Type</label>
                        <select name="type" id="type" class="form-control" onchange="updateTradeType()" required>
                            <option value="buy">Buy with Money</option>
                            <option value="trade">Trade with Item</option>
                        </select>
                    </div>

                    <div class="form-group" id="buy-section">
                        <label for="offer_amount">Offer Amount ($)</label>
                        <input type="number" step="0.01" name="offer_amount" id="offer_amount" class="form-control" placeholder="Enter your offer">
                        <small class="form-text text-muted">Item price: ${{ number_format($item->price, 2) }}</small>
                    </div>

                    <div class="form-group" id="trade-section" style="display:none;">
                        <label for="offer_item_id">Select Item to Trade</label>
                        <select name="offer_item_id" id="offer_item_id" class="form-control">
                            <option value="">Choose an item...</option>
                            @foreach($myItems as $myItem)
                                <option value="{{ $myItem->id }}">{{ $myItem->name }} (${{ number_format($myItem->price, 2) }})</option>
                            @endforeach
                        </select>
                        @if($myItems->isEmpty())
                            <small class="form-text text-danger">You don't have any available items to trade.</small>
                        @endif
                    </div>

                    <div class="form-group">
                        <label for="message">Message (Optional)</label>
                        <textarea name="message" id="message" class="form-control" rows="3" placeholder="Add a message with your offer..."></textarea>
                    </div>

                    <input type="hidden" name="item_id" value="{{ $item->id }}">
                </div>

                <div class="card-footer">
                    <button type="submit" class="btn btn-success" id="submitBtn">
                        <i class="fas fa-check"></i> Send Offer
                    </button>
                    <a href="{{ route('marketplace.index') }}" class="btn btn-secondary">Back</a>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function updateTradeType() {
    const type = document.getElementById('type').value;
    document.getElementById('buy-section').style.display = type === 'buy' ? 'block' : 'none';
    document.getElementById('trade-section').style.display = type === 'trade' ? 'block' : 'none';
}
</script>
@endsection
