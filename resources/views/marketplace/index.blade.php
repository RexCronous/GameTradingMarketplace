@extends('layouts.main')

@section('title', 'Marketplace')

@section('content')
<div class="container-fluid">
    <div class="row mb-3">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Browse Items</h3>
                </div>
                <div class="card-body">
                    <form method="GET" class="row">
                        <div class="col-md-3">
                            <input type="text" name="search" class="form-control" placeholder="Search items..." value="{{ request('search') }}">
                        </div>
                        <div class="col-md-2">
                            <input type="number" name="min_price" class="form-control" placeholder="Min Price" value="{{ request('min_price') }}">
                        </div>
                        <div class="col-md-2">
                            <input type="number" name="max_price" class="form-control" placeholder="Max Price" value="{{ request('max_price') }}">
                        </div>
                        <div class="col-md-2">
                            <button type="submit" class="btn btn-primary w-100">
                                <i class="fas fa-search"></i> Filter
                            </button>
                        </div>
                        <div class="col-md-1">
                            <a href="{{ route('marketplace.index') }}" class="btn btn-secondary w-100">Reset</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        @if($items->count() > 0)
            @foreach($items as $item)
            <div class="col-md-3 mb-4">
                <div class="card item-card h-100">
                    <img src="{{ $item->image ? asset('storage/' . $item->image) : 'https://via.placeholder.com/400' }}" class="card-img-top" style="height: 250px; object-fit: cover;">
                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title">{{ $item->name }}</h5>
                        <p class="card-text text-muted text-truncate">{{ $item->description }}</p>
                        <p class="text-sm text-muted">by {{ $item->user->profile->username ?? $item->user->name }}</p>
                        <p class="card-text font-weight-bold text-primary mt-2">₱{{ number_format($item->price, 2) }}</p>
                        <div class="mt-auto">
                            <a href="{{ route('items.show', $item) }}" class="btn btn-primary btn-sm w-100">View Details</a>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        @else
            <div class="col-12">
                <div class="alert alert-info">
                    <i class="fas fa-info-circle"></i> No items found matching your criteria.
                </div>
            </div>
        @endif
    </div>

    @if($items->count() > 0)
        <div class="row">
            <div class="col-md-12">
                {{ $items->links() }}
            </div>
        </div>
    @endif
</div>
@endsection
