@extends('layouts.app')

@section('title', $item->name)
@section('page-title', $item->name)

@section('content')
<div class="row">
    <div class="col-md-6">
        <div class="card">
            <div class="card-body">
                @if($item->image)
                    <img src="{{ $item->getImageUrl() }}" alt="{{ $item->name }}" class="img-fluid">
                @else
                    <div class="bg-secondary d-flex align-items-center justify-content-center" style="height: 400px;">
                        <i class="fas fa-image fa-5x text-white"></i>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">{{ $item->name }}</h3>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <h4 class="text-primary">${{ number_format($item->price, 2) }}</h4>
                </div>

                <div class="mb-3">
                    <h6>Category</h6>
                    <span class="badge badge-info">{{ $item->category ?? 'Uncategorized' }}</span>
                </div>

                <div class="mb-3">
                    <h6>Seller</h6>
                    <p>
                        <strong>{{ $item->user->name }}</strong>
                        @if($item->user->profile)
                            <br>
                            <small class="text-muted">@{{ $item->user->profile->username }}</small>
                        @endif
                    </p>
                </div>

                <div class="mb-3">
                    <h6>Description</h6>
                    <p>{{ $item->description ?? 'No description provided' }}</p>
                </div>

                <div class="mb-3">
                    <h6>Status</h6>
                    <span class="badge badge-{{ $item->status === 'available' ? 'success' : ($item->status === 'sold' ? 'danger' : 'warning') }}">
                        {{ ucfirst($item->status) }}
                    </span>
                </div>

                @if($item->isAvailable())
                    <a href="{{ route('user.transactions.create', $item) }}" class="btn btn-primary btn-lg btn-block">
                        <i class="fas fa-shopping-cart"></i> Make an Offer
                    </a>
                @else
                    <button class="btn btn-secondary btn-lg btn-block" disabled>
                        Item Not Available
                    </button>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
