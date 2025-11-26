@extends('layouts.app')

@section('page-title', 'Welcome')

@section('content')
<div class="landing-header">
    <h1 class="text-center">🎮 Game Trading Marketplace</h1>
    <p class="text-center">Buy, Sell, and Trade Game Assets Easily</p>
</div>

<div class="container py-5">
    <div class="row text-center">
        <div class="col-md-4 mb-3">
            <div class="feature-box">
                <i class="fas fa-store fa-3x text-primary mb-3"></i>
                <h4>Open Marketplace</h4>
                <p>Browse item listings freely without authentication.</p>
            </div>
        </div>
        <div class="col-md-4 mb-3">
            <div class="feature-box">
                <i class="fas fa-gamepad fa-3x text-success mb-3"></i>
                <h4>Trade Game Items</h4>
                <p>Login only when you want to trade or manage assets.</p>
            </div>
        </div>
        <div class="col-md-4 mb-3">
            <div class="feature-box">
                <i class="fas fa-shield-alt fa-3x text-warning mb-3"></i>
                <h4>Secure Transactions</h4>
                <p>Built using Laravel Authentication & Role System.</p>
            </div>
        </div>
    </div>
</div>

<div class="landing-btn d-flex justify-content-center mb-5">
    <a href="{{ route('marketplace.index') }}" class="btn btn-main mt-3 bg-primary">
        Explore Marketplace
    </a>
</div>

@endsection
