@extends('layouts.app')

@section('title', 'Marketplace')
@section('page-title', 'Marketplace')

@section('content')
<div class="row mb-3">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Search & Filter</h3>
            </div>
            <div class="card-body">
                <form method="GET" action="{{ route('user.marketplace.index') }}" class="form-inline">
                    <div class="form-group mr-2 mb-2">
                        <input type="text" name="search" class="form-control" placeholder="Search items..." 
                               value="{{ request('search') }}">
                    </div>

                    <div class="form-group mr-2 mb-2">
                        <select name="category" class="form-control">
                            <option value="">All Categories</option>
                            @foreach($categories as $cat)
                                <option value="{{ $cat }}" @if(request('category') === $cat) selected @endif>
                                    {{ $cat }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group mr-2 mb-2">
                        <input type="number" name="min_price" class="form-control" placeholder="Min Price" 
                               value="{{ request('min_price') }}" min="0">
                    </div>

                    <div class="form-group mr-2 mb-2">
                        <input type="number" name="max_price" class="form-control" placeholder="Max Price" 
                               value="{{ request('max_price') }}" min="0">
                    </div>

                    <button type="submit" class="btn btn-primary mb-2">
                        <i class="fas fa-search"></i> Search
                    </button>
                    <a href="{{ route('user.marketplace.index') }}" class="btn btn-secondary mb-2 ml-2">
                        <i class="fas fa-redo"></i> Reset
                    </a>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="row">
    @forelse($items as $item)
        <div class="col-md-4 mb-4">
            <div class="card item-card">
                @if($item->image)
                    <img src="{{ $item->getImageUrl() }}" class="card-img-top" alt="{{ $item->name }}" style="height: 200px; object-fit: cover;">
                @else
                    <div class="card-img-top bg-secondary" style="height: 200px; display: flex; align-items: center; justify-content: center;">
                        <i class="fas fa-image fa-2x text-white"></i>
                    </div>
                @endif
                <div class="card-body">
                    <h5 class="card-title">{{ $item->name }}</h5>
                    <p class="card-text text-muted">{{ Str::limit($item->description, 60) }}</p>
                    <div class="mb-2">
                        <span class="badge badge-info">{{ $item->category ?? 'Uncategorized' }}</span>
                        <span class="badge badge-success">Seller: {{ $item->user->name }}</span>
                    </div>
                    <h4 class="text-primary">${{ number_format($item->price, 2) }}</h4>
                </div>
                <div class="card-footer bg-transparent">
                    <a href="{{ route('user.marketplace.show', $item) }}" class="btn btn-sm btn-primary btn-block">
                        <i class="fas fa-eye"></i> View Details
                    </a>
                </div>
            </div>
        </div>
    @empty
        <div class="col-md-12">
            <div class="alert alert-info">
                <i class="fas fa-info-circle"></i> No items found matching your criteria.
            </div>
        </div>
    @endforelse
</div>

@if($items->hasPages())
    <div class="row mt-3">
        <div class="col-md-12 d-flex justify-content-center">
            {{ $items->links() }}
        </div>
    </div>
@endif
@endsection
