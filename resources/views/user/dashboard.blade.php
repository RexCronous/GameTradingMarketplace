@extends('layouts.app')

@section('title', 'Dashboard')
@section('page-title', 'User Dashboard')

@section('content')
<div class="row">
    <div class="col-md-3">
        <div class="info-box bg-info">
            <span class="info-box-icon"><i class="fas fa-cube"></i></span>
            <div class="info-box-content">
                <span class="info-box-text">Total Items</span>
                <span class="info-box-number">{{ $stats['total_items'] ?? 0 }}</span>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="info-box bg-success">
            <span class="info-box-icon"><i class="fas fa-check-circle"></i></span>
            <div class="info-box-content">
                <span class="info-box-text">Available Items</span>
                <span class="info-box-number">{{ $stats['available_items'] ?? 0 }}</span>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="info-box bg-warning">
            <span class="info-box-icon"><i class="fas fa-clock"></i></span>
            <div class="info-box-content">
                <span class="info-box-text">Pending Trades</span>
                <span class="info-box-number">{{ $stats['pending_trades'] ?? 0 }}</span>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="info-box bg-danger">
            <span class="info-box-icon"><i class="fas fa-money-bill-wave"></i></span>
            <div class="info-box-content">
                <span class="info-box-text">Total Sales</span>
                <span class="info-box-number">${{ number_format($stats['total_sales'] ?? 0, 2) }}</span>
            </div>
        </div>
    </div>
</div>

<div class="row mt-4">
    <div class="col-md-6">
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">Quick Actions</h3>
            </div>
            <div class="card-body">
                <a href="{{ route('user.items.create') }}" class="btn btn-primary btn-block mb-2">
                    <i class="fas fa-plus"></i> Add New Item
                </a>
                <a href="{{ route('marketplace.index') }}" class="btn btn-success btn-block mb-2">
                    <i class="fas fa-shopping-cart"></i> Browse Marketplace
                </a>
                <a href="{{ route('user.transactions.index') }}" class="btn btn-info btn-block">
                    <i class="fas fa-history"></i> View Transactions
                </a>
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="card card-info">
            <div class="card-header">
                <h3 class="card-title">Your Statistics</h3>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-6">
                        <div class="description-block border-right">
                            <h5 class="description-header">{{ $stats['completed_trades'] ?? 0 }}</h5>
                            <span class="description-text">Completed Trades</span>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="description-block">
                            <h5 class="description-header">{{ $stats['available_items'] ?? 0 }}</h5>
                            <span class="description-text">Items for Sale</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
