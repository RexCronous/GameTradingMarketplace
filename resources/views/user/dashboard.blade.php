@extends('layouts.main')

@section('title', 'User Dashboard')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-3 col-6">
            <div class="small-box bg-info">
                <div class="inner">
                    <h3>{{ $myItems }}</h3>
                    <p>My Items</p>
                </div>
                <div class="icon">
                    <i class="fas fa-box"></i>
                </div>
                <a href="{{ route('items.create') }}" class="small-box-footer">Add Item <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>

        <div class="col-lg-3 col-6">
            <div class="small-box bg-success">
                <div class="inner">
                    <h3>{{ $myTransactions }}</h3>
                    <p>Transactions</p>
                </div>
                <div class="icon">
                    <i class="fas fa-exchange-alt"></i>
                </div>
                <a href="{{ route('transactions.index') }}" class="small-box-footer">View All <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>

        <div class="col-lg-3 col-6">
            <div class="small-box bg-warning">
                <div class="inner">
                    <h3>{{ $pendingOffers }}</h3>
                    <p>Pending Offers</p>
                </div>
                <div class="icon">
                    <i class="fas fa-hourglass-half"></i>
                </div>
                <a href="{{ route('transactions.index') }}" class="small-box-footer">Manage <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>

        <div class="col-lg-3 col-6">
            <div class="small-box bg-danger">
                <div class="inner">
                    <h3>{{ Auth::user()->profile->username ?? 'N/A' }}</h3>
                    <p>Username</p>
                </div>
                <div class="icon">
                    <i class="fas fa-user"></i>
                </div>
                <a href="{{ route('profile.edit') }}" class="small-box-footer">Edit <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">My Items</h3>
                    <div class="card-tools">
                        <a href="{{ route('items.create') }}" class="btn btn-primary btn-sm">
                            <i class="fas fa-plus"></i> Add Item
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    @if($userItems->count() > 0)
                        <div class="row">
                            @foreach($userItems as $item)
                            <div class="col-md-6 mb-3">
                                <div class="card item-card">
                                    <img src="{{ $item->image ? asset('storage/' . $item->image) : 'https://via.placeholder.com/300' }}" class="card-img-top" style="height: 200px; object-fit: cover;">
                                    <div class="card-body">
                                        <h5 class="card-title">{{ $item->name }}</h5>
                                        <p class="card-text text-muted text-truncate">{{ $item->description }}</p>
                                        <p class="card-text font-weight-bold text-primary">₱{{ number_format($item->price, 2) }}</p>
                                        <span class="badge badge-{{ $item->status === 'available' ? 'success' : ($item->status === 'sold' ? 'danger' : 'warning') }}">
                                            {{ ucfirst($item->status) }}
                                        </span>
                                    </div>
                                    <div class="card-footer bg-white border-top">
                                        <a href="{{ route('items.show', $item) }}" class="btn btn-sm btn-info">View</a>
                                        @if($item->status === 'available')
                                            <a href="{{ route('items.edit', $item) }}" class="btn btn-sm btn-warning">Edit</a>
                                            <form action="{{ route('items.destroy', $item) }}" method="POST" style="display: inline;">
                                                @csrf @method('DELETE')
                                                <button class="btn btn-sm btn-danger" onclick="return confirm('Delete this item?')">Delete</button>
                                            </form>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                        {{ $userItems->links() }}
                    @else
                        <p class="text-muted">You haven't added any items yet. <a href="{{ route('items.create') }}">Create your first item!</a></p>
                    @endif
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Pending Offers</h3>
                </div>
                <div class="card-body p-0">
                    @if($myPendingTrades->count() > 0)
                        @foreach($myPendingTrades as $trade)
                        <div class="border-bottom p-3">
                            <p class="font-weight-bold mb-1">{{ $trade->item->name }}</p>
                            <p class="text-sm text-muted mb-2">
                                @if(Auth::id() === $trade->seller_id)
                                    From: {{ $trade->buyer->name }}
                                @else
                                    To: {{ $trade->seller->name }}
                                @endif
                            </p>
                            <a href="{{ route('transactions.show', $trade) }}" class="btn btn-sm btn-primary">View</a>
                        </div>
                        @endforeach
                        {{ $myPendingTrades->links() }}
                    @else
                        <p class="p-3 text-muted mb-0">No pending offers</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
