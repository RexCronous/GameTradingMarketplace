@extends('layouts.app')

@section('page-title', 'Marketplace')

@section('content')
<div class="row mb-3">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <form action="{{ route('marketplace.index') }}" method="GET" class="row">
                    <div class="col-md-6">
                        <input type="text" name="search" class="form-control" placeholder="Search items..." value="{{ request('search') }}">
                    </div>
                    <div class="col-md-3">
                        <select name="sort" class="form-control">
                            <option value="">Sort by</option>
                            <option value="price_asc" @if(request('sort') === 'price_asc') selected @endif>Price: Low to High</option>
                            <option value="price_desc" @if(request('sort') === 'price_desc') selected @endif>Price: High to Low</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <button type="submit" class="btn btn-primary btn-block">Search</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="row">
    @forelse($items as $item)
        <div class="col-md-4 mb-3">
            <div class="card item-card h-100">
                <img src="{{ $item->getImageUrl() }}" class="card-img-top" alt="{{ $item->name }}" style="height: 200px; object-fit: cover;">
                <div class="card-body">
                    <h5 class="card-title">{{ $item->name }}</h5>
                    <p class="card-text text-muted text-sm">{{ Str::limit($item->description, 80) }}</p>
                    <p class="card-text"><strong>${{ number_format($item->price, 2) }}</strong></p>
                    <p class="card-text"><small class="text-muted">by {{ $item->user->name }}</small></p>
                </div>
                <div class="card-footer bg-white border-top">
                    <a href="{{ route('marketplace.show', $item) }}" class="btn btn-sm btn-primary btn-block">
                        <i class="fas fa-eye"></i> View Details
                    </a>
                </div>
            </div>
        </div>
    @empty
        <div class="col-md-12">
            <div class="alert alert-info text-center">
                <h4>No items found</h4>
                <p>Try adjusting your search criteria.</p>
            </div>
        </div>
    @endforelse
</div>

<div class="row mt-3">
    <div class="col-md-12">
        {{ $items->links() }}
    </div>
</div>
@endsection
